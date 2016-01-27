<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     *
     * @Assert\NotBlank
     * @Assert\Length(max=200)
     */
    private $title;


    /**
     * @ORM\Column(type="string", length=200, nullable=false)
     *
     * @var  string
     *
     * @Assert\NotBlank
     * @Assert\Length(max=200)
     */
    private $employer;

    /**
     * @ORM\Column(type="text", nullable=false)
     *
     * @var string
     *
     * @Assert\NotBlank
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
     * @return Attachment
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param Attachment|null $attachment
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @param Tag[]|ArrayCollection $tags
     */
    public function setTags($tags)
    {
        if (!$tags instanceof ArrayCollection) {
            $tags = new ArrayCollection($tags);
        }
        $this->tags = $tags;
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
