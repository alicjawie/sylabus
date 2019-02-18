<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ExtraField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * ExtraField controller.
 *
 * @Route("admin/extra-field")
 */
class ExtraFieldController extends BaseController
{
    /**
     * Lists all extraField entities.
     *
     * @Route("/", name="extra-field_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $extraFields = $em->getRepository('AppBundle:ExtraField')->findAll();

        return $this->render('extrafield/index.html.twig', array(
            'extraFields' => $extraFields,
        ));
    }

    /**
     * Creates a new extraField entity.
     *
     * @Route("/new", name="extra-field_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $extraField = new Extrafield();
        $form = $this->createForm('AppBundle\Form\ExtraFieldType', $extraField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($extraField);
            $em->flush();

            $this->addFlash(
                'notice',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('extra-field_show', array('id' => $extraField->getId()));
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'notice',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $form->getErrors()
            );
        }

        return $this->render('extrafield/new.html.twig', array(
            'extraField' => $extraField,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a extraField entity.
     *
     * @Route("/{id}", name="extra-field_show")
     * @Method("GET")
     * @param ExtraField $extraField
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(ExtraField $extraField)
    {
        $deleteForm = $this->createDeleteForm($extraField);

        return $this->render('extrafield/show.html.twig', array(
            'extraField' => $extraField,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing extraField entity.
     *
     * @Route("/{id}/edit", name="extra-field_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param ExtraField $extraField
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, ExtraField $extraField)
    {
        $deleteForm = $this->createDeleteForm($extraField);
        $editForm = $this->createForm('AppBundle\Form\ExtraFieldType', $extraField);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('extra-field_edit', array('id' => $extraField->getId()));
        }

        return $this->render('extrafield/edit.html.twig', array(
            'extraField' => $extraField,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a extraField entity.
     *
     * @Route("/{id}", name="extra-field_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param ExtraField $extraField
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, ExtraField $extraField)
    {
        $form = $this->createDeleteForm($extraField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($extraField);
            $em->flush();
        }

        return $this->redirectToRoute('extra-field_index');
    }

    /**
     * Creates a form to delete a extraField entity.
     *
     * @param ExtraField $extraField The extraField entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ExtraField $extraField)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('extra-field_delete', array('id' => $extraField->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
