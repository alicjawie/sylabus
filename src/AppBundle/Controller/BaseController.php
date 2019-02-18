<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FieldOfStudy;
use AppBundle\Entity\Subject;
use AppBundle\Entity\User;
use AppBundle\Entity\Year;
use AppBundle\Repository\FieldOfStudyRepository;
use AppBundle\Repository\SubjectRepository;
use AppBundle\Repository\YearRepository;
use AppBundle\Service\USOSService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * @return FieldOfStudyRepository|ObjectRepository
     */
    protected function getFieldOfStudyRepo()
    {
        return $this->getDoctrine()->getManager()->getRepository(FieldOfStudy::class);
    }

    /**
     * @return User|ObjectRepository
     */
    protected function getUserRepo()
    {
        return $this->getDoctrine()->getManager()->getRepository(User::class);
    }

    /**
     * @return SubjectRepository|ObjectRepository
     */
    protected function getSubjectRepo()
    {
        return $this->getDoctrine()->getManager()->getRepository(Subject::class);
    }

    /**
     * @return YearRepository|ObjectRepository
     */
    protected function getYearRepo()
    {
        return $this->getDoctrine()->getManager()->getRepository(Year::class);
    }

    /**
     * @return USOSService
     */
    protected function getUSOSService()
    {
        return $this->container->get(USOSService::class);
    }
}
