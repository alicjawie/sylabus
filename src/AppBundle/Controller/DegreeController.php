<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Degree;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Degree controller.
 *
 * @Route("admin/degree")
 */
class DegreeController extends Controller
{
    /**
     * Lists all degree entities.
     *
     * @Route("/", name="degree_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $degrees = $em->getRepository('AppBundle:Degree')->findAll();

        return $this->render('degree/index.html.twig', array(
            'degrees' => $degrees,
        ));
    }

    /**
     * Creates a new degree entity.
     *
     * @Route("/new", name="degree_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $degree = new Degree();
        $form = $this->createForm('AppBundle\Form\DegreeType', $degree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($degree);
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('degree_show', array('id' => $degree->getId()));
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'error',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $form->getErrors()
            );
        }

        return $this->render('degree/new.html.twig', array(
            'degree' => $degree,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a degree entity.
     *
     * @Route("/{id}", name="degree_show")
     * @Method("GET")
     * @param Degree $degree
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Degree $degree)
    {
        $deleteForm = $this->createDeleteForm($degree);

        return $this->render('degree/show.html.twig', array(
            'degree' => $degree,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing degree entity.
     *
     * @Route("/{id}/edit", name="degree_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Degree $degree
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Degree $degree)
    {
        $deleteForm = $this->createDeleteForm($degree);
        $editForm = $this->createForm('AppBundle\Form\DegreeType', $degree);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('degree_edit', array('id' => $degree->getId()));
        } elseif ($editForm->isSubmitted() && !$editForm->isValid()) {
            $this->addFlash(
                'error',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $editForm->getErrors()
            );
        }

        return $this->render('degree/edit.html.twig', array(
            'degree' => $degree,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a degree entity.
     *
     * @Route("/{id}", name="degree_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Degree $degree
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Degree $degree)
    {
        $form = $this->createDeleteForm($degree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($degree);
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_DELETED')
            );
        }

        return $this->redirectToRoute('degree_index');
    }

    /**
     * Creates a form to delete a degree entity.
     *
     * @param Degree $degree The degree entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Degree $degree)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('degree_delete', array('id' => $degree->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
