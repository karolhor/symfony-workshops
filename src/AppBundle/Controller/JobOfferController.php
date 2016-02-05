<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use AppBundle\Event\AppEvents;
use AppBundle\Event\JobCreatedEvent;
use AppBundle\Form\JobType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JobOfferController extends Controller
{
    /**
     * @Route(
     *     "/{_locale}", name="listJobs",
     *     requirements={"_locale":"en|pl"},
     *     defaults={"_locale":"en"}
     * )
     *
     * @Cache(
     *     smaxage=60
     * )
     */
    public function listAction()
    {
        $jobs = $this->getDoctrine()->getRepository('AppBundle:Job')
            ->findAll();

        $listGeneration = new \DateTime();

        return $this->render('jobOffer/list.html.twig', [
            'jobs' => $jobs,
            'listGeneration' => $listGeneration
        ]);
    }

    /**
     * @Route("/job/new", name="newJob")
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $job = new Job();

        $form = $this->createForm(JobType::class, $job);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $job->getAttachment()->getFile()) {
                $job->setAttachment(null);
            } else {
                $this->get('attachment.attachment_upload_manager')
                    ->upload($job->getAttachment());
            }

            $job->setAuthor($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            $event = new JobCreatedEvent($job);
            $this->get('event_dispatcher')->dispatch(AppEvents::JOB_CREATE, $event);

            return $this->redirectToRoute('showJob', ['id' => $job->getId()]);
        }

        return $this->render('jobOffer/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Job $job
     * @return Response
     *
     * @Route("/job/show/{id}", name="showJob")
     * @ParamConverter("job", class="AppBundle\Entity\Job")
     */
    public function showAction(Job $job, Request $request)
    {
        $response = new Response();
        $response->setPublic();

        $etag = md5($job->getDescription());
        $response->setEtag($etag);

        if($response->isNotModified($request)) {
            return $response;
        }
        sleep(1);
        $now = new \DateTime();
        $job->setTitle($now->format(\DateTime::ISO8601). $job->getTitle());
        return $this->render(
            'jobOffer/show.html.twig',
            [
                'job' => $job
            ],
            $response
        );
    }

    /**
     * @Route(
     *     "/test/{_locale}/{year}/{title}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "en|pl",
     *         "_format": "html|rss",
     *         "year": "\d+"
     *     }
     * )
     */
    public function testAction($year, $_locale, $title, $_format)
    {
        return $this->render('base.html.twig');
    }

    public function versionAction()
    {
        $response = new Response();
        $response->setSharedMaxAge(10);

        $now = new \DateTime();
        $response->setContent("version: ".$now->format(\DateTime::ISO8601));

        return $response;
    }
}
