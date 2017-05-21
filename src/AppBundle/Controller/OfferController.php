<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class OfferController extends MainController
{
    /**
     * @Route("/offers", name="offers")
     */
	public function index2Action(Request $request){
		return $this->indexAction($request, 1);
	}
    /**
     * @Route("/offers/{page}", name="offerpage", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $search = "";


        $offerpage =  $em->getRepository('AppBundle\Entity\Offerpage\OfferPage')->find(1);
        $perPage = 25;
        $offset = ($page - 1) * $perPage;
        if( !is_null($request->query->get('search'))){
        	$search = $request->query->get('search');
        	$offers = $em->getRepository('AppBundle\Entity\Offerpage\Offer\Offer')->getPaginated($perPage, $offset, array('search' => $search ));
        }
        else
        {
        	$offers = $em->getRepository('AppBundle\Entity\Offerpage\Offer\Offer')->getPaginated($perPage, $offset, array('search' => $search));
        }

        if( $page > $offers['last_page'] ){
        	return $this->redirect($this->generateUrl('offerpage'));
        }

        $array_twig = $this->defaultInfo($request);


        $this->trackVisit();

        $array_twig['id_page'] = 'offer_page';
        $array_twig['search'] = $search;
        $array_twig['page'] = $page;
        $array_twig['offer'] = $offerpage;
        $array_twig['offers'] = $offers;
        return $this->render('AppBundle:offer:index.html.twig',$array_twig);
    }
}
