<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Anime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Anime controller.
 *
 * @Route("anime")
 */
class AnimeController extends Controller
{
    /**
     * Lists all anime entities.
     *
     * @Route("/", name="anime_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $animes = $em->getRepository('AppBundle:Anime')->findAll();

        return $this->render('anime/index.html.twig', array(
            'animes' => $animes,
        ));
    }

    /**
     * Creates a new anime entity.
     *
     * @Route("/new", name="anime_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $anime = new Anime();
        $form = $this->createForm('AppBundle\Form\AnimeType', $anime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anime);
            $em->flush();

            return $this->redirectToRoute('anime_show', array('id' => $anime->getId()));
        }

        return $this->render('anime/new.html.twig', array(
            'anime' => $anime,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a anime entity.
     *
     * @Route("/{id}", name="anime_show")
     * @Method("GET")
     */
    public function showAction(Anime $anime)
    {
        $deleteForm = $this->createDeleteForm($anime);

        return $this->render('anime/show.html.twig', array(
            'anime' => $anime,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing anime entity.
     *
     * @Route("/{id}/edit", name="anime_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Anime $anime)
    {
        $deleteForm = $this->createDeleteForm($anime);
        $editForm = $this->createForm('AppBundle\Form\AnimeType', $anime);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('anime_edit', array('id' => $anime->getId()));
        }

        return $this->render('anime/edit.html.twig', array(
            'anime' => $anime,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a anime entity.
     *
     * @Route("/{id}", name="anime_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Anime $anime)
    {
        $form = $this->createDeleteForm($anime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($anime);
            $em->flush();
        }

        return $this->redirectToRoute('anime_index');
    }

    /**
     * Creates a form to delete a anime entity.
     *
     * @param Anime $anime The anime entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Anime $anime)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('anime_delete', array('id' => $anime->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
