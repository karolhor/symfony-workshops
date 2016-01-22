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
            ->add('title', TextType::class, [
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'PHP Programmer']])
            ->add('employer', TextType::class, [
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'e.g. Google Inc.']])
            ->add('description', TextareaType::class, [
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Requirements, Social Package, Salary', 'rows' => '20']])
            ->add('type', TextType::class, [
                'label'=> 'Job type',
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'e.g. PHP']])
            ->add('attachment', FileType::class, [
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'attr' => ['class' => 'form-control']])
            ->add('attachmentName', TextType::class, [
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'e.g. Resume']])
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
