<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ExtraField
 *
 * @ORM\Table(name="extra_field")
 * @ORM\Entity()
 */
class ExtraField extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="extraFields")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $subject;

    /**
     * @return int
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param int $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * Set subject.
     *
     * @param Subject|null $subject
     *
     * @return ExtraField
     */
    public function setSubject(Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return Subject|null
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
