<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FieldOfStudy
 *
 * @ORM\Table(name="additional_field")
 * @ORM\Entity()
 */
class AdditionalField extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ects", type="integer")
     */
    private $ECTS;

    /**
     * @var boolean
     *
     * @ORM\Column(name="exam", type="boolean")
     */
    private $exam;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set eCTS
     *
     * @param integer $eCTS
     *
     * @return AdditionalField
     */
    public function setECTS($eCTS)
    {
        $this->ECTS = $eCTS;

        return $this;
    }

    /**
     * Get eCTS
     *
     * @return integer
     */
    public function getECTS()
    {
        return $this->ECTS;
    }

    /**
     * Set exam
     *
     * @param boolean $exam
     *
     * @return AdditionalField
     */
    public function setExam($exam)
    {
        $this->exam = $exam;

        return $this;
    }

    /**
     * @return bool
     */
    public function getExam()
    {
        return $this->exam;
    }
}
