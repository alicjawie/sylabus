<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Subject
 *
 * @ORM\Table(name="subject")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubjectRepository")
 */
class Subject extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @OneToOne(targetEntity="NumberOfHours", cascade={"persist"})
     * @JoinColumn(name="number_of_hours_id", referencedColumnName="id")
     */
    private $numberOfHours;

    /**
     *
     * @OneToOne(targetEntity="AdditionalField", cascade={"persist"})
     * @JoinColumn(name="additional_field_id", referencedColumnName="id")
     */
    private $additionalField;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $lecturer;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Semester", mappedBy="subjects")
     */
    private $semesters;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ExtraField", mappedBy="subject", cascade={"persist"})
     */
    private $extraFields;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="CourseContent", mappedBy="subject", cascade={"persist"})
     */
    private $courseContents;

    /**
     * Subject constructor.
     *
     * @param bool $setData
     * @param string $name
     * @param string $description
     * @param NumberOfHours $numberOfHours
     * @param AdditionalField $additionalField
     * @param string $code
     * @param string|null $lecturer
     */
    public function __construct(
        bool $setData = false,
        string $name = null,
        string $description = null,
        NumberOfHours $numberOfHours = null,
        AdditionalField $additionalField = null,
        string $code = null,
        string $lecturer = ''
    ) {
        $this->semesters = new ArrayCollection();
        $this->extraFields = new ArrayCollection();
        $this->courseContents = new ArrayCollection();

        if ($setData) {
            $this->name = $name;
            $this->description = $description;
            $this->numberOfHours = $numberOfHours;
            $this->additionalField = $additionalField;
            $this->code = $code;
            $this->lecturer = $lecturer;
        }
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
     * @return Subject
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
     * Set description
     *
     * @param string $description
     *
     * @return Subject
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set numberOfHours
     *
     * @param \AppBundle\Entity\NumberOfHours $numberOfHours
     *
     * @return Subject
     */
    public function setNumberOfHours(NumberOfHours $numberOfHours = null)
    {
        $this->numberOfHours = $numberOfHours;

        return $this;
    }

    /**
     * Get numberOfHours
     *
     * @return \AppBundle\Entity\NumberOfHours
     */
    public function getNumberOfHours()
    {
        return $this->numberOfHours;
    }

    /**
     * Set additionalFieldId
     *
     * @param AdditionalField $additionalFieldId
     *
     * @return Subject
     */
    public function setAdditionalField(AdditionalField $additionalFieldId = null)
    {
        $this->additionalField = $additionalFieldId;

        return $this;
    }

    /**
     * Get additionalFieldId
     *
     * @return \AppBundle\Entity\AdditionalField
     */
    public function getAdditionalField()
    {
        return $this->additionalField;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }


    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add subject
     *
     * @param Subject $subject
     *
     * @return Subject
     */
    public function addSubject(Subject $subject)
    {
        $this->semesters[] = $subject;

        return $this;
    }

    /**
     * Remove subject
     *
     * @param Subject $subject
     */
    public function removeSubject(Subject $subject)
    {
        $this->semesters->removeElement($subject);
    }

    /**
     * Get subjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubjects()
    {
        return $this->semesters;
    }

    /**
     * Add semester.
     *
     * @param \AppBundle\Entity\Semester $semester
     *
     * @return Subject
     */
    public function addSemester(Semester $semester)
    {
        $this->semesters[] = $semester;

        return $this;
    }

    /**
     * Remove semester.
     *
     * @param \AppBundle\Entity\Semester $semester
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSemester(Semester $semester)
    {
        return $this->semesters->removeElement($semester);
    }

    /**
     * Get semesters.
     *
     * @return ArrayCollection
     */
    public function getSemesters()
    {
        return $this->semesters;
    }

    /**
     * Add extraField.
     *
     * @param ExtraField $extraField
     *
     * @return Subject
     */
    public function addExtraField(ExtraField $extraField)
    {
        $extraField->setSubject($this);
        $this->extraFields->add($extraField);

        return $this;
    }

    /**
     * Remove extraField.
     *
     * @param \AppBundle\Entity\ExtraField $extraField
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeExtraField(ExtraField $extraField)
    {
        return $this->extraFields->removeElement($extraField);
    }

    /**
     * Add CourseContent.
     *
     * @param CourseContent $courseContent
     *
     * @return Subject
     */
    public function addCourseContent(CourseContent $courseContent)
    {
        $courseContent->setSubject($this);
        $this->courseContents->add($courseContent);

        return $this;
    }

    /**
     * Remove CourseContent.
     *
     * @param \AppBundle\Entity\CourseContent $courseContent
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCourseContent(CourseContent $courseContent)
    {
        return $this->courseContents->removeElement($courseContent);
    }

    /**
     * Get extraFields.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExtraFields()
    {
        return $this->extraFields;
    }

    /**
     * @param string $lecturer
     */
    public function setLecturer($lecturer)
    {
        $this->lecturer = $lecturer;
    }

    /**
     * @return string
     */
    public function getLecturer()
    {
        return $this->lecturer;
    }

    /**
     * @return ArrayCollection
     */
    public function getCourseContents()
    {
        return $this->courseContents;
    }
}
