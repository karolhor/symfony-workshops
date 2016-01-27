<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Job
 *
 * @ORM\Entity
 * @ORM\Table("jobs")
 */
class Job
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=false)
     *
     * @var  string
     */
    private $title;


    /**
     * @ORM\Column(type="string", length=200, nullable=false)
     *
     * @var  string
     */
    private $employer;

    /**
     * @ORM\Column(type="text", nullable=false)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobType", inversedBy="jobs")
     *
     * @var  JobType
     */
    private $type;

    /**
     * @var Attachment
     *
     * @ORM\OneToOne(targetEntity="Attachment", cascade={"persist"})
     */
    private $attachment;

    /** @var  Tag[] */
    private $tags = [];

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @param string $employer
     */
    public function setEmployer($employer)
    {
        $this->employer = $employer;
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
     * @return JobType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param JobType $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Attachment
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param Attachment $attachment
     */
    public function setAttachment(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @param Tag[] $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
