<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CourseContent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * CourseContent controller.
 *
 * @Route("admin/course-content")
 */
class CourseContentController extends BaseController
{
    /**
     * Lists all CourseContent entities.
     *
     * @Route("/", name="course-content_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $CourseContents = $em->getRepository('AppBundle:CourseContent')->findAll();

        return $this->render('CourseContent/index.html.twig', array(
            'CourseContents' => $CourseContents,
        ));
    }

    /**
     * Creates a new CourseContent entity.
     *
     * @Route("/new", name="course-content_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $CourseContent = new CourseContent();
        $form = $this->createForm('AppBundle\Form\CourseContentType', $CourseContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($CourseContent);
            $em->flush();

            $this->addFlash(
                'notice',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('course-content_show', array('id' => $CourseContent->getId()));
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'notice',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $form->getErrors()
            );
        }

        return $this->render('CourseContent/new.html.twig', array(
            'CourseContent' => $CourseContent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CourseContent entity.
     *
     * @Route("/{id}", name="course-content_show")
     * @Method("GET")
     * @param CourseContent $CourseContent
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(CourseContent $CourseContent)
    {
        $deleteForm = $this->createDeleteForm($CourseContent);

        return $this->render('CourseContent/show.html.twig', array(
            'CourseContent' => $CourseContent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CourseContent entity.
     *
     * @Route("/{id}/edit", name="course-content_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param CourseContent $CourseContent
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, CourseContent $CourseContent)
    {
        $deleteForm = $this->createDeleteForm($CourseContent);
        $editForm = $this->createForm('AppBundle\Form\CourseContentType', $CourseContent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('course-content_edit', array('id' => $CourseContent->getId()));
        }

        return $this->render('CourseContent/edit.html.twig', array(
            'CourseContent' => $CourseContent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CourseContent entity.
     *
     * @Route("/{id}", name="course-content_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param CourseContent $CourseContent
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, CourseContent $CourseContent)
    {
        $form = $this->createDeleteForm($CourseContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($CourseContent);
            $em->flush();
        }

        return $this->redirectToRoute('course-content_index');
    }

    /**
     * Creates a form to delete a CourseContent entity.
     *
     * @param CourseContent $CourseContent The CourseContent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CourseContent $CourseContent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('course-content_delete', array('id' => $CourseContent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
