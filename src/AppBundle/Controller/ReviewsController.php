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
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);
        $items = $em->getRepository('AppBundle\Entity\Review\Item\Item')->getForDisplay();

        return $this->render('AppBundle:reviews:index.html.twig', array('review' => $review, 'items' => $items));
    }
}
