<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class BaxiController extends MainController
{
    /**
     * @Route("/baxi", name="baxi")
     */
    public function indexAction(Request $request)
    {
    	$array_twig = $this->defaultInfo($request);
        $this->trackVisit();

        $array_twig['id_page'] = 'baxi';
        return $this->render('AppBundle:baxi:index.html.twig',$array_twig);
    }
    
    /**
     * @Route("/baxi/terms-and-coditions", name="baxi-tc")
     */
    public function indexTermsAction(Request $request)
    {
    	$array_twig = $this->defaultInfo($request);
        $this->trackVisit();

        $array_twig['id_page'] = 'baxi';
        return $this->render('AppBundle:baxi:baxi-tc.html.twig',$array_twig);
    }
}
