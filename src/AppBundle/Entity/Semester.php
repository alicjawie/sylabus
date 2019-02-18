<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Semester
 *
 * @ORM\Table(name="semester")
 * @ORM\Entity()
 */
class Semester extends AbstractEntity
{
    const SUMMER_TYPE = 'SUMMER_TYPE';
    const WINTER_TYPE = 'WINTER_TYPE';

    public static $SUPPORTED_TYPES = [
        self::SUMMER_TYPE => 'SUMMER_TYPE',
        self::WINTER_TYPE => 'WINTER_TYPE'
    ];

    /**
     * @var string
     *
     * @ORM\Column(name="year_of_study", type="string", length=128)
     * @Assert\NotBlank()
     */
    private $yearOfStudy;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=32)
     *
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Subject", inversedBy="semesters", cascade={"persist"})
     * @ORM\JoinTable(name="subject_semester",
     *      joinColumns={@ORM\JoinColumn(name="subject_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="semester_id", referencedColumnName="id")}
     * )
     */
    private $subjects;

    /**
     * @ORM\ManyToOne(targetEntity="FieldOfStudy", inversedBy="semesters")
     * @ORM\JoinColumn(name="field_of_study_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $fieldOfStudy;


    public function __construct(
        bool $haveData = false,
        int $yearOfStudy = null,
        string $type = null,
        FieldOfStudy $fieldOfStudy = null
    ) {
        $this->subjects = new ArrayCollection();

        if ($haveData) {
            $this->type = $type;
            $this->fieldOfStudy = $fieldOfStudy;
            $this->yearOfStudy = $yearOfStudy;
        }
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
     * @return Subject[]|ArrayCollection
     */
    public function getSubjects()
    {
        return $this->subjects->toArray();
    }

    /**
     * @return string
     */
    public function getYearOfStudy()
    {
        return $this->yearOfStudy;
    }

    public function addSubject(Subject $subject)
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects->add($subject);
        }

        return $this;
    }

    public function removeSubject(Subject $subject)
    {
        if ($this->subjects->contains($subject)) {
            $this->subjects->remove($subject);
        }

        return $this;
    }

    public function setSubjects($subjects)
    {
        if (is_array($subjects) || $subjects instanceof ArrayCollection) {
            foreach ($subjects as $subject) {
                if (!$this->subjects->contains($subject)) {
                    $this->subjects->add($subject);
                }
            }
        } else {
            if (!$this->subjects->contains($subjects)) {
                $this->subjects->add($subjects);
            }
        }
    }

    /**
     * @param string $yearOfStudy
     */
    public function setYearOfStudy(string $yearOfStudy)
    {
        $this->yearOfStudy = $yearOfStudy;
    }

    /**
     * @return mixed $fieldOfStudy
     */
    public function getFieldOfStudy()
    {
        return $this->fieldOfStudy;
    }

    /**
     * @param mixed $fieldOfStudy
     */
    public function setFieldOfStudy($fieldOfStudy)
    {
        $this->fieldOfStudy = $fieldOfStudy;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Semester
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
