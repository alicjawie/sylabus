<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FieldOfStudy;
use AppBundle\Form\FieldOfStudyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fieldofstudy controller.
 *
 * @Route("admin/field-of-study")
 */
class FieldOfStudyController extends BaseController
{
    /**
     * Lists all fieldOfStudy entities.
     *
     * @Route("/", name="field-of-study_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $fieldOfStudies = $this->getFieldOfStudyRepo()->findAll();

        return $this->render('fieldofstudy/index.html.twig', array(
            'fieldOfStudies' => $fieldOfStudies,
        ));
    }

    /**
     * Creates a new fieldOfStudy entity.
     *
     * @Route("/new", name="field-of-study_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $fieldOfStudy = new FieldOfStudy();
        $form = $this->createForm(FieldOfStudyType::class, $fieldOfStudy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldOfStudy);
            $em->flush();

            $this->addFlash(
                'notice',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('field-of-study_show', array('id' => $fieldOfStudy->getId()));
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'notice',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $form->getErrors()
            );
        }

        return $this->render('fieldofstudy/new.html.twig', array(
            'fieldOfStudy' => $fieldOfStudy,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fieldOfStudy entity.
     *
     * @Route("/{id}", name="field-of-study_show")
     * @Method("GET")
     * @param FieldOfStudy $fieldOfStudy
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(FieldOfStudy $fieldOfStudy)
    {
        $deleteForm = $this->createDeleteForm($fieldOfStudy);

        return $this->render('fieldofstudy/show.html.twig', array(
            'fieldOfStudy' => $fieldOfStudy,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fieldOfStudy entity.
     *
     * @Route("/{id}/edit", name="field-of-study_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param FieldOfStudy $fieldOfStudy
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, FieldOfStudy $fieldOfStudy)
    {
        $deleteForm = $this->createDeleteForm($fieldOfStudy);
        $editForm = $this->createForm(FieldOfStudyType::class, $fieldOfStudy);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('field-of-study_edit', array('id' => $fieldOfStudy->getId()));
        } elseif ($editForm->isSubmitted() && !$editForm->isValid()) {
            $this->addFlash(
                'error',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $editForm->getErrors()
            );
        }

        return $this->render('fieldofstudy/edit.html.twig', array(
            'fieldOfStudy' => $fieldOfStudy,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fieldOfStudy entity.
     *
     * @Route("/{id}", name="field-of-study_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param FieldOfStudy $fieldOfStudy
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, FieldOfStudy $fieldOfStudy)
    {
        $form = $this->createDeleteForm($fieldOfStudy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fieldOfStudy);
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_DELETED')
            );
        }

        return $this->redirectToRoute('field-of-study_index');
    }

    /**
     * Creates a form to delete a fieldOfStudy entity.
     *
     * @param FieldOfStudy $fieldOfStudy The fieldOfStudy entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldOfStudy $fieldOfStudy)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('field-of-study_delete', array('id' => $fieldOfStudy->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
