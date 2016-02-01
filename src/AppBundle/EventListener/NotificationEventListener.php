<?php

namespace AppBundle\EventListener;

use AppBundle\Event\JobCreatedEvent;
use Psr\Log\LoggerInterface;

/**
 * Class NotificationEventListener
 */
class NotificationEventListener
{
    /** @var  LoggerInterface */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onJobCreate(JobCreatedEvent $event)
    {
        $this->logger->info('[notification] '.$event->getJob()->getTitle());
    }
}
