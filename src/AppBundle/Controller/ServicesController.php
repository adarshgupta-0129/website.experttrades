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
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);
        $items = $em->getRepository('AppBundle\Entity\Service\Item\Item')->getForDisplay();
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'ASC'], 9, 0);

        return $this->render('AppBundle:services:index.html.twig', array('website' => $website, 'service' => $service, 'items' => $items, 'footer_images' => $footerImages));
    }
}
