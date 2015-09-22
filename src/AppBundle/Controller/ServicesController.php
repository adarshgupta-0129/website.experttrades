<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;

class ServicesController extends MainController
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
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:services:index.html.twig',
        array(
          'website' => $website,
          'service' => $service,
          'items' => $items,
          'footer_images' => $footerImages,
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }
}
