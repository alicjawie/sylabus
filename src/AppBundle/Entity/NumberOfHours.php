<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FieldOfStudy
 *
 * @ORM\Table(name="number_of_hours")
 * @ORM\Entity()
 */
class NumberOfHours extends AbstractEntity
{

    /**
     * @var integer
     *
     * @ORM\Column(name="name", type="integer", nullable=true)
     */
    private $lecture;

    /**
     * @var integer
     *
     * @ORM\Column(name="exercises", type="integer", nullable=true)
     */
    private $exercises;

    /**
     * @var integer
     *
     * @ORM\Column(name="laboratories", type="integer", nullable=true)
     */
    private $laboratories;

    /**
     * @var integer
     *
     * @ORM\Column(name="exercises_laboratories", type="integer", nullable=true)
     */
    private $exercisesLaboratories;

    /**
     * @var integer
     *
     * @ORM\Column(name="own_work", type="integer", nullable=true)
     */
    private $ownWork;

    /**
     * @var integer
     *
     * @ORM\Column(name="sum", type="integer", nullable=true)
     */
    private $sum;


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
     * Set lecture
     *
     * @param integer $lecture
     *
     * @return NumberOfHours
     */
    public function setLecture($lecture)
    {
        $this->lecture = $lecture;
        $this->countHours();

        return $this;
    }

    /**
     * Get lecture
     *
     * @return integer
     */
    public function getLecture()
    {
        return $this->lecture;
    }

    /**
     * Set exercises
     *
     * @param integer $exercises
     *
     * @return NumberOfHours
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;
        $this->countHours();

        return $this;
    }

    /**
     * Get exercises
     *
     * @return integer
     */
    public function getExercises()
    {
        return $this->exercises;
    }

    /**
     * Set laboratories
     *
     * @param integer $laboratories
     *
     * @return NumberOfHours
     */
    public function setLaboratories($laboratories)
    {
        $this->laboratories = $laboratories;
        $this->countHours();

        return $this;
    }

    /**
     * Get laboratories
     *
     * @return integer
     */
    public function getLaboratories()
    {
        return $this->laboratories;
    }

    /**
     * Set exercisesLaboratories
     *
     * @param integer $exercisesLaboratories
     *
     * @return NumberOfHours
     */
    public function setExercisesLaboratories($exercisesLaboratories)
    {
        $this->exercisesLaboratories = $exercisesLaboratories;
        $this->countHours();

        return $this;
    }

    /**
     * Get exercisesLaboratories
     *
     * @return integer
     */
    public function getExercisesLaboratories()
    {
        return $this->exercisesLaboratories;
    }

    /**
     * Set ownWork
     *
     * @param integer $ownWork
     *
     * @return NumberOfHours
     */
    public function setOwnWork($ownWork)
    {
        $this->ownWork = $ownWork;
        $this->countHours();

        return $this;
    }

    /**
     * Get ownWork
     *
     * @return integer
     */
    public function getOwnWork()
    {
        return $this->ownWork;
    }

    /**
     * Set sum
     *
     * @param integer $sum
     *
     * @return NumberOfHours
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return integer
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set sum
     *
     * @return NumberOfHours
     */
    public function countHours()
    {
        $this->sum =
            $this->lecture+
            $this->exercises+
            $this->laboratories+
            $this->exercisesLaboratories+
            $this->ownWork;

        return $this;
    }
}
