<?php

namespace ProjectBundle\Controller;

use CoreBundle\Entity\User;
use ProjectBundle\Entity\Project;
use ProjectBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Account controller.
 *
 */
class ProjectController extends Controller
{
    /**
     * Lists all account entities.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('ProjectBundle:Project')->createQueryBuilder('p')
            ->where('(p.owner = :user OR  :user MEMBER OF p.participants)')
            ->andWhere('p.closed = :false')
            ->setParameter('false', false)
            ->setParameter('user', $this->getUser())
            ->getQuery()->getResult();

        return $this->render('@Project/Project/index.html.twig', array(
            'projects' => $projects,
        ));
    }

    /**
     * Creates a new account entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        $project = new Project();
        $project->setOwner($this->getUser());
        return $this->editAction($request, $project);
    }

    /**
     * Displays a form to edit an existing account entity.
     * @param Request $request
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Project $project)
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($project);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Projet enregistré");

            return $this->redirectToRoute('project_index');
        }

        return $this->render('@Project/Project/edit.html.twig', array(
            'projet' => $project,
            'form' => $form->createView(),
        ));
    }

    public function ficheAction(Project $project)
    {
        $project->addParticipant($project->getOwner());

        $usersObj = $this->getDoctrine()->getRepository('CoreBundle:User')
            ->createQueryBuilder('u')
            ->where('u.id NOT IN (:participants) ')
            ->setParameter('participants', $project->getParticipants())
            ->orderBy('u.username', 'ASC')
            ->groupBy('u.id')
            ->getQuery()->getResult();
        $users = [];
        /** @var User $u */
        foreach ($usersObj AS $u) {
            $users [$u->getId()] = $u->getFullname();
        }

        return $this->render('@Project/Project/fiche.html.twig', [
            'project' => $project,
            'users' => $users,
            'types' => [
                \ProjectBundle\Entity\Requete::TYPE_BUG => 'Bug',
                \ProjectBundle\Entity\Requete::TYPE_NEW => 'Nouvelle demande',
                \ProjectBundle\Entity\Requete::TYPE_IDEA => 'Idée',
            ],
        ]);
    }

    public function deleteAction(Request $request, Project $project)
    {
        try {

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "Projet supprimé");
        } catch (\Exception $e) {
            $this->addFlash('danger', "Erreur");

        }

        return $this->redirectToRoute('project_index');
    }


    public function addUserAction(Request $request, Project $project)
    {
        $user = $this->getDoctrine()->getRepository('CoreBundle:User')->find($request->get('user'));
        if ($user != null) {
            $project->addParticipant($user);
            $this->getDoctrine()->getManager()->flush();
            return new JsonResponse(['success' => true]);
        }
        return new JsonResponse(['success' => false]);

    }
}
