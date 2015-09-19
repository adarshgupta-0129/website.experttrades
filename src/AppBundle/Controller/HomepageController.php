<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);
        $reviews =  $em->getRepository('AppBundle\Entity\Review\Item\Item')->findBy([],['created' => 'ASC'], 4, 0);
        $services =  $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy([],['id' => 'ASC'], 3, 0);
        $images =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'ASC'], 8, 0);
        $footerImages = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'ASC'], 9, 0);

        return $this->render('AppBundle:homepage:index.html.twig',
        array('website' => $website, 'homepage' => $homepage, 'reviews' => $reviews,
              'services' => $services, 'images' => $images, 'footer_images' => $footerImages));
    }
}
