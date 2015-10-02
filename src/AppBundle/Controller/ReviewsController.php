<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;

class ReviewsController extends MainController
{
    /**
     * @Route("/reviews/{page}", name="reviews", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $items = $em->getRepository('AppBundle\Entity\Review\Item\Item')->getForDisplay(10, $offset);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:reviews:index.html.twig',
        array(
          'page' => $page,
          'website' => $website,
          'review' => $review,
          'items' => $items,
          'footer_images' => $footerImages,
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }

    /**
     * @Route("/review/{id}", name="review_view")
     */
    public function viewAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);
        $item = $em->getRepository('AppBundle\Entity\Review\Item\Item')->find($id);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:reviews:view.html.twig',
        array(
          'website' => $website,
          'review' => $review,
          'item' => $item,
          'footer_images' => $footerImages,
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }
}
