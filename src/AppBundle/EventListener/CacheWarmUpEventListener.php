<?php

namespace AppBundle\EventListener;

use AppBundle\Event\AppEvents;
use AppBundle\Event\JobCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CacheWarmUpEventListener
 */
class CacheWarmUpEventListener implements EventSubscriberInterface
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

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            AppEvents::JOB_CREATE => 'onJobCreate'
        ];
    }

    public function onJobCreate(JobCreatedEvent $event)
    {
        $job = $event->getJob();
        $this->logger->info(sprintf("[cache warm-up] %s @ %s", $job->getTitle(), $job->getEmployer()));
    }

}
