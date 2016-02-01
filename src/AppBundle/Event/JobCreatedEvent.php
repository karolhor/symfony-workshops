<?php

namespace AppBundle\Event;

use AppBundle\Entity\Job;
use Symfony\Component\EventDispatcher\Event;

class JobCreatedEvent extends Event
{
    /** @var  Job */
    private $job;

    /**
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }
}
