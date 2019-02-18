<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FieldOfStudy
 *
 * @ORM\Table(name="field_of_study")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FieldOfStudyRepository")
 */
class FieldOfStudy extends AbstractEntity
{
    const MODE_FULL_TIME  = 'MODE_FULL_TIME';
    const MODE_EXTRAMURAL = 'MODE_EXTRAMURAL';
    const MODE_EVENING    = 'MODE_EVENING';

    static public $SUPPORTED_MODES = [
        self::MODE_FULL_TIME  => 'MODE_FULL_TIME',
        self::MODE_EVENING    => 'MODE_EVENING',
        self::MODE_EXTRAMURAL => 'MODE_EXTRAMURAL'
    ];

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mode", type="string", length=255)
     */
    private $mode;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Degree", inversedBy="fieldOfStudy")
     * @ORM\JoinColumn(name="degree_id", referencedColumnName="id")
     *
     */
    private $degree;

    /**
     * @var Year
     *
     * @ORM\ManyToOne(targetEntity="Year", inversedBy="fieldOfStudy")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     *
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=255)
     */
    private $language;

    /**
     * @ORM\OneToMany(targetEntity="Semester", mappedBy="fieldOfStudy")
     */
    private $semesters;

    public function __construct()
    {
        $this->semesters = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     *
     * @return FieldOfStudy
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
     * Set mode
     *
     * @param string $mode
     *
     * @return FieldOfStudy
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set degree
     *
     * @param string $degree
     *
     * @return FieldOfStudy
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * Get degree
     *
     * @return string
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * @param Year $year
     */
    public function setYear(Year $year)
    {
        $this->year = $year;
    }

    /**
     * @return Year
     */
    public function getYear()
    {
        return $this->year;
    }


    /**
     * Set language
     *
     * @param string $language
     *
     * @return FieldOfStudy
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function addSemester(Semester $semester)
    {
        if (!$this->semesters->contains($semester)) {
            $this->semesters->add($semester);
        }

        return $this;
    }

    public function removeSemester(Semester $semester)
    {
        if ($this->semesters->contains($semester)) {
            $this->semesters->remove($semester);
        }

        return $this;
    }

    /**
     * @return Semester[]|ArrayCollection
     */
    public function getSemesters()
    {
        return $this->semesters->toArray();
    }
}
