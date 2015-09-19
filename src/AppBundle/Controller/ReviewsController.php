<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReviewsController extends Controller
{
    /**
     * @Route("/reviews", name="reviews")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);
        $items = $em->getRepository('AppBundle\Entity\Review\Item\Item')->getForDisplay();
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'ASC'], 9, 0);

        return $this->render('AppBundle:reviews:index.html.twig', array('website' => $website, 'review' => $review, 'items' => $items, 'footer_images' => $footerImages));
    }
}
