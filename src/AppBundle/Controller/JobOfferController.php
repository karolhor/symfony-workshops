<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use AppBundle\Form\JobType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JobOfferController extends Controller
{
    /**
     * @Route("/", name="listJobs")
     */
    public function listAction()
    {
        return $this->render('jobOffer/list.html.twig');
    }

    /**
     * @Route("/job/new", name="newJob")
     */
    public function newAction(Request $request)
    {
        $job = new Job();

        $form = $this->createForm(JobType::class, $job);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (null === $job->getAttachment()->getFile()) {
                $job->setAttachment(null);
            } else {
                $this->get('attachment.attachment_upload_manager')
                    ->upload($job->getAttachment());
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

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
    public function showAction(Job $job)
    {
        return $this->render('jobOffer/show.html.twig', [
            'job' => $job
        ]);
    }
}
