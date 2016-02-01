<?php

namespace AppBundle\EventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class AccessDeniedRequestListener
 */
class AccessDeniedRequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequest()->getLocale() == 'de') {
            $response = new Response("", 403);
            $event->setResponse($response);
        }
    }
}
