<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Year
 *
 * @ORM\Table(name="year")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\YearRepository")
 */
class Year extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string")
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity="FieldOfStudy", mappedBy="year")
     */
    private $fieldOfStudy;

    public function __construct()
    {
        $this->fieldOfStudy = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->year;
    }

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
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param string $year
     */
    public function setYear(string $year)
    {
        $this->year = $year;
    }

    /**
     * Add fieldOfStudy
     *
     * @param FieldOfStudy $fieldOfStudy
     *
     * @return Year
     */
    public function addFieldOfStudy(FieldOfStudy $fieldOfStudy)
    {
        $this->fieldOfStudy[] = $fieldOfStudy;

        return $this;
    }

    /**
     * Remove fieldOfStudy
     *
     * @param FieldOfStudy $fieldOfStudy
     */
    public function removeFieldOfStudy(FieldOfStudy $fieldOfStudy)
    {
        $this->fieldOfStudy->removeElement($fieldOfStudy);
    }

    /**
     * Get fieldOfStudy
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFieldOfStudy()
    {
        return $this->fieldOfStudy;
    }
}
