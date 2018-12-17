<?php

namespace ProjectBundle\Controller;

use ProjectBundle\Entity\Project;
use ProjectBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
            ->where('p.owner = :user')
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
        return $this->render('@Project/Project/fiche.html.twig',[
            'project'=>$project,
            'types'=>[
                \ProjectBundle\Entity\Requete::TYPE_BUG=>'Bug',
                \ProjectBundle\Entity\Requete::TYPE_NEW=>'Nouvelle demande',
                \ProjectBundle\Entity\Requete::TYPE_IDEA=>'Idée',
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

}
