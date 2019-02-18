<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CourseContent;
use AppBundle\Entity\ExtraField;
use AppBundle\Entity\Subject;
use AppBundle\Form\SubjectType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Subject controller.
 *
 * @Route("admin/subject")
 */
class SubjectController extends BaseController
{

    /**
     * Lists all subject entities.
     *
     * @Route("/", name="subject_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $subjects = $this->getSubjectRepo()->findAll();

        return $this->render('subject/index.html.twig', array(
            'subjects' => $subjects,
        ));
    }

    /**
     * Creates a new subject entity.
     *
     * @Route("/new", name="subject_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /** @var ExtraField $extraField */
            foreach ($subject->getExtraFields() as $extraField) {
                $extraField->setSubject($subject);
                $em->persist($extraField);
            }
            /** @var CourseContent $courseContent */
            foreach ($subject->getCourseContents() as $courseContent) {
                $courseContent->setSubject($subject);
                $em->persist($courseContent);
            }
            $em->persist($subject);
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('subject_show', array('id' => $subject->getId()));
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'error',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $form->getErrors()
            );
        }

        return $this->render('subject/new.html.twig', array(
            'subject' => $subject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a subject entity.
     *
     * @Route("/{id}", name="subject_show")
     * @Method("GET")
     * @param Subject $subject
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Subject $subject)
    {
        $deleteForm = $this->createDeleteForm($subject);

        return $this->render('subject/show.html.twig', array(
            'subject' => $subject,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing subject entity.
     *
     * @Route("/{id}/edit", name="subject_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Subject $subject
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Subject $subject)
    {
        $deleteForm = $this->createDeleteForm($subject);

        $originalFields = new ArrayCollection();

        foreach ($subject->getExtraFields() as $extraField) {
            $originalFields->add($extraField);
        }

        $originalCourseContents = new ArrayCollection();

        foreach ($subject->getCourseContents() as $extraField) {
            $originalCourseContents->add($extraField);
        }

        $editForm = $this->createForm(SubjectType::class, $subject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($originalFields as $extraField) {
                if (false === $subject->getExtraFields()->contains($extraField)) {
                    $subject->getExtraFields()->removeElement($extraField);
                    $em->remove($extraField);
                }
            }
            /** @var ExtraField $extraField */
            foreach ($subject->getExtraFields() as $extraField) {
                $extraField->setSubject($subject);
                $em->persist($extraField);
            }
            foreach ($originalCourseContents as $courseContent) {
                if (false === $subject->getCourseContents()->contains($courseContent)) {
                    $subject->getExtraFields()->removeElement($courseContent);
                    $em->remove($courseContent);
                }
            }
            /** @var CourseContent $courseContent */
            foreach ($subject->getCourseContents() as $courseContent) {
                $courseContent->setSubject($subject);
                $em->persist($courseContent);
            }
            $em->persist($subject);
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('subject_edit', array('id' => $subject->getId()));
        } elseif ($editForm->isSubmitted() && !$editForm->isValid()) {
            $this->addFlash(
                'error',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $editForm->getErrors()
            );
        }

        return $this->render('subject/edit.html.twig', array(
            'subject' => $subject,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a subject entity.
     *
     * @Route("/{id}", name="subject_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Subject $subject
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Subject $subject)
    {
        $form = $this->createDeleteForm($subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subject);
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_DELETED')
            );
        }

        return $this->redirectToRoute('subject_index');
    }

    /**
     * Creates a form to delete a subject entity.
     *
     * @param Subject $subject The subject entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Subject $subject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subject_delete', array('id' => $subject->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
