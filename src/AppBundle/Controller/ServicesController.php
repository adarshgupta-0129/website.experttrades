<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServicesController extends Controller
{
    /**
     * @Route("/services", name="services")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:services:index.html.twig', array());
    }
}
