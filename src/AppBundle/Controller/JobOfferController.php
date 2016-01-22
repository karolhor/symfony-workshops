<?php

namespace AppBundle\Controller;

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
    public function newAction()
    {
        return $this->render('jobOffer/new.html.twig');
    }

    /**
     * @Route("/job/show/1", name="showJob")
     */
    public function showAction()
    {
        return $this->render('jobOffer/show.html.twig');
    }
}
