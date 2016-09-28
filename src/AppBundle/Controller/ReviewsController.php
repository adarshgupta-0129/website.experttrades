<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class ReviewsController extends MainController
{
    /**
     * @Route("/reviews/{page}", name="reviews", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $array_twig = $this->defaultInfo($request);
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $items = $em->getRepository('AppBundle\Entity\Review\Item\Item')->getForDisplay(10, $offset);
        $this->trackVisit();

        $array_twig['id_page'] = 'reviews_page';
        $array_twig['review'] = $review;
        $array_twig['items'] = $items;
        $array_twig['page'] = $page;
        return $this->render('AppBundle:reviews:index.html.twig',$array_twig);
    }

    /**
     * @Route("/review/{id}", name="review_view")
     */
    public function viewAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $array_twig = $this->defaultInfo($request);
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);
        $item = $em->getRepository('AppBundle\Entity\Service\Item\Item')->findOneBy([
          'page_slug' => $slug,
          'page_active' => true
        ]);
        if(!is_object($item)){
            throw new NotFoundHttpException("Page not found");
        }
        $this->trackVisit();

        $array_twig['id_page'] = 'review_page';
        $array_twig['review'] = $review;
        $array_twig['item'] = $item;
        $array_twig['snipped'] = $this->richSnippedReviewJson($em, $request, $id);
        return $this->render('AppBundle:reviews:view.html.twig',$array_twig);

    }
}
