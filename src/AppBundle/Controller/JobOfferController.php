<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use AppBundle\Form\JobType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->render('jobOffer/show.html.twig', [
                'job' => $job
            ]);
        }

        return $this->render('jobOffer/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/job/show/1", name="showJob")
     */
    public function showAction()
    {
        return $this->render('jobOffer/showFromList.html.twig', [
            'job' => new Job()
        ]);
    }
}
