<?php

namespace ProjectBundle\Controller;

use ProjectBundle\Entity\Comment;
use ProjectBundle\Entity\Project;
use ProjectBundle\Entity\Response;
use ProjectBundle\Form\RequeteType;
use ProjectBundle\Form\ResponseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Account controller.
 *
 */
class RequeteController extends Controller
{

    /**
     * Creates a new account entity.
     * @param Request $request
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Project $project)
    {
        $req = new \ProjectBundle\Entity\Requete();
        $req->setProject($project);
        $req->setInitiator($this->getUser());
        return $this->editAction($request, $req);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function newCommentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $response = $em->getRepository('ProjectBundle:Response')->find($request->get('response'));

        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $comment->setResponse($response);
        $comment->setComment($request->get('comment'));
        $em->persist($comment);
        $em->flush();
        return new JsonResponse(['url'=>$this->generateUrl('request_index',['id'=>$response->getRequest()->getId(),'_fragment'=>$response->getId()])]);
    }

    /**
     * Displays a form to edit an existing account entity.
     * @param Request $request
     * @param \ProjectBundle\Entity\Requete $req
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, \ProjectBundle\Entity\Requete $req)
    {
        $form = $this->createForm(RequeteType::class, $req);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($req);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "Demande enregistrée");
            return $this->redirectToRoute('project_fiche', ['id' => $req->getProject()->getId()]);
        }

        return $this->render('@Project/Request/edit.html.twig', array(
            'request' => $request,
            'form' => $form->createView(),
        ));
    }

    public function getResponseForm(Request $req, Response $response, $forms)
    {
        if ($response->getResponsesChildren()->count() == 0) {
            $rep = new Response();
            $rep->setAuthor($this->getUser());
            $rep->setResponsesParent($response);
            $form = $this->createForm(ResponseType::class, $rep);
            $form->handleRequest($req);

            $forms[$response->getId()] = $form->createView();

            return $forms;
        }
        return $this->getResponseForm($req, $response->getLastResponsesChildren(), $forms);

    }

    public function indexAction(Request $req, \ProjectBundle\Entity\Requete $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rep = new Response();
        $rep->setAuthor($this->getUser());
        $rep->setRequest($request);

        $form = $this->createForm(ResponseType::class, $rep);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($rep);
            $em->flush();
           return $this->redirectToRoute('request_index',['id'=>$request->getId(),'_fragment'=>$rep->getId()]);
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->render('@Project/Request/wall.html.twig', [
            'request' => $request,
            'form' => $form->createView()
        ]);
    }


}
