<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Degree
 *
 * @ORM\Table(name="degree")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DegreeRepository")
 */
class Degree extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="FieldOfStudy", mappedBy="degree")
     *
     */
    private $fieldOfStudy;

    /**
     * Degree constructor.
     */
    public function __construct()
    {
        $this->fieldOfStudy = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Degree
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add fieldOfStudy
     *
     * @param \AppBundle\Entity\FieldOfStudy $fieldOfStudy
     *
     * @return Degree
     */
    public function addFieldOfStudy(FieldOfStudy $fieldOfStudy)
    {
        $this->fieldOfStudy[] = $fieldOfStudy;

        return $this;
    }

    /**
     * Remove fieldOfStudy
     *
     * @param \AppBundle\Entity\FieldOfStudy $fieldOfStudy
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
