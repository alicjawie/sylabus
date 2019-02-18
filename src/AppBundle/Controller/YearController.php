<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Year;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Year controller.
 *
 * @Route("admin/year")
 */
class YearController extends Controller
{
    /**
     * Lists all year entities.
     *
     * @Route("/", name="year_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $years = $em->getRepository('AppBundle:Year')->findAll();

        return $this->render('year/index.html.twig', array(
            'years' => $years,
        ));
    }

    /**
     * Creates a new year entity.
     *
     * @Route("/new", name="year_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $year = new Year();
        $form = $this->createForm('AppBundle\Form\YearType', $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($year);
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('year_show', array('id' => $year->getId()));
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'error',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $form->getErrors()
            );
        }

        return $this->render('year/new.html.twig', array(
            'year' => $year,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a year entity.
     *
     * @Route("/{id}", name="year_show")
     * @Method("GET")
     * @param Year $year
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Year $year)
    {
        $deleteForm = $this->createDeleteForm($year);

        return $this->render('year/show.html.twig', array(
            'year' => $year,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing year entity.
     *
     * @Route("/{id}/edit", name="year_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Year $year
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Year $year)
    {
        $deleteForm = $this->createDeleteForm($year);
        $editForm = $this->createForm('AppBundle\Form\YearType', $year);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_SAVED')
            );

            return $this->redirectToRoute('year_edit', array('id' => $year->getId()));
        } elseif ($editForm->isSubmitted() && !$editForm->isValid()) {
            $this->addFlash(
                'error',
                $this->get('translator')->trans('CHANGES_CAN_NOT_BE_SAVE') . $editForm->getErrors()
            );
        }

        return $this->render('year/edit.html.twig', array(
            'year' => $year,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a year entity.
     *
     * @Route("/{id}", name="year_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Year $year
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Year $year)
    {
        $form = $this->createDeleteForm($year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($year);
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('CHANGES_DELETED')
            );
        }

        return $this->redirectToRoute('admin_year_index');
    }

    /**
     * Creates a form to delete a year entity.
     *
     * @param Year $year The year entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Year $year)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('year_delete', array('id' => $year->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
