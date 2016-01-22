<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

        $form = $this->createFormBuilder($job)
            ->add('title')
            ->add('employer')
            ->add('description', TextareaType::class)
            ->add('type', TextType::class, ['label'=> 'Job type'])
            ->add('attachment', FileType::class)
            ->add('attachmentName')
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
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
