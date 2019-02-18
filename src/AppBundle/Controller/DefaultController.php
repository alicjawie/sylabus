<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FieldOfStudy;
use AppBundle\Entity\Subject;
use Doctrine\ORM\EntityNotFoundException;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController
{
    /**
     * @Route("/{year}", name="homepage", requirements={"year"="[0-9]+/[0-9]+"})
     *
     * @param null|string $year
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($year = null)
    {
        if (!$year) {
            $currentDate = new \DateTime();
            $nextDate = new \DateTime();
            $year = $currentDate->format('Y') . '/' . $nextDate->modify('+1 year')->format('Y');
        }
        $fieldsOfStudiesFullTime = $this->getFieldOfStudyRepo()->findByFullTimeMode($year);
        $fieldsOfStudiesExtramural = $this->getFieldOfStudyRepo()->findByExtramuralMode($year);
        $years = $this->getYearRepo()->findAll();

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'fieldsOfStudiesFullTime' => $fieldsOfStudiesFullTime,
            'fieldsOfStudiesExtramural' => $fieldsOfStudiesExtramural,
            'years' => $years
        ]);
    }

    /**
     * @Route("/help", name="help")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function helpAction()
    {
        return $this->render('help.html.twig', [
        ]);
    }

    /**
     * Lists all subjects entities.
     *
     * @Route("/subjects/ajax", name="subject_ajax")
     * @Method("GET")
     * @param Request $request
     * @return JsonResponse
     */
    public function getSubjectByAjaxAction(Request $request)
    {
        $term = $request->query->get('term')['term'];
        $subjects = $this->getSubjectRepo()->getForAjaxSearch($term);

        return new JsonResponse($subjects);
    }

    /**
     * @Route("/set-language/{locale}", name="set_language")
     *
     * @param Request $request
     * @param string $locale
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setLanguageAction(Request $request, $locale = 'pl')
    {
        $request->getSession()->set('_locale', $locale);
        $request->setLocale($locale);

        return $this->redirectToRoute('homepage');
    }

    /**
     * Finds and displays a subject entity.
     *
     * @Route("subjects/{id}", name="subject_detail_show")
     * @Method("GET")
     * @param Request $request
     * @param Subject|null $subject
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subjectDetailAction(Request $request, ?Subject $subject)
    {
        if (empty($subject)) {
            $selectedSubject = $request->query->get('selectedSubject');
            if (empty($selectedSubject)) {
                return $this->redirectToRoute('homepage');
            }
            $subject = $this->getSubjectRepo()->find($selectedSubject);
        }


        return $this->render('subject/homeDetail.html.twig', array(
            'subject' => $subject,
        ));
    }

    /**
     * Lists all subject entities.
     *
     * @Route("/subjects-list/{fieldOfStudy}", name="subject_home_list")
     * @Method("GET")
     * @param FieldOfStudy|null $fieldOfStudy
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws EntityNotFoundException
     */
    public function subjectListOfFieldOfStudyAction(?FieldOfStudy $fieldOfStudy)
    {
        if (is_null($fieldOfStudy)) {
            throw new EntityNotFoundException();
        }

        return $this->render('subject/homeList.html.twig', array(
            'fieldOfStudy' => $fieldOfStudy,
        ));
    }

    /**
     * Lists all subject entities.
     *
     * @Route("/subjects-list-pdf/{fieldOfStudy}", name="subject_home_list_pdf")
     * @Method("GET")
     * @param FieldOfStudy|null $fieldOfStudy
     * @return PdfResponse
     * @throws EntityNotFoundException
     */
    public function generateSubjectListOfFieldOfStudyToPdfAction(?FieldOfStudy $fieldOfStudy)
    {
        if (is_null($fieldOfStudy)) {
            throw new EntityNotFoundException();
        }

        $html = $this->renderView('pdf/subjectList.html.twig', array(
            'fieldOfStudy' => $fieldOfStudy,
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf',
            array(
                'Content-Type' => 'application/pdf'
            )
        );
    }

    /**
     * Finds and displays a subject entity.
     *
     * @Route("subjects-pdf/{id}", name="subject_detail_show_pdf")
     * @Method("GET")
     * @param Request $request
     * @param Subject|null $subject
     * @return PdfResponse
     */
    public function generateSubjectDetailToPdfAction(Request $request, ?Subject $subject)
    {
        if (empty($subject)) {
            $selectedSubject = $request->query->get('selectedSubject');
            if (empty($selectedSubject)) {
                return $this->redirectToRoute('homepage');
            }
            $subject = $this->getSubjectRepo()->find($selectedSubject);
        }


        $html = $this->renderView('pdf/subjectDetail.html.twig', array(
            'subject' => $subject,
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }
}
