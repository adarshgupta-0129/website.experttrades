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
        $em = $this->getDoctrine()->getManager();
        $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);
        $items = $em->getRepository('AppBundle\Entity\Service\Item\Item')->getForDisplay();

        return $this->render('AppBundle:services:index.html.twig', array('service' => $service, 'items' => $items));
    }
}
