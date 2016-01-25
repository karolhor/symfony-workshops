<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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

    private $attachment;

    /** @var  string */
    private $attachmentName;



    /**
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="job_tags",
     *     joinColumns={@ORM\JoinColumn(name="job_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")})
     * )
     *
     * @var  Tag[] | ArrayCollection
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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
     * @return mixed
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param mixed $attachment
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @return string
     */
    public function getAttachmentName()
    {
        return $this->attachmentName;
    }

    /**
     * @param string $attachmentName
     */
    public function setAttachmentName($attachmentName)
    {
        $this->attachmentName = $attachmentName;
    }

    /**
     * @return Tag[]|ArrayCollection
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
