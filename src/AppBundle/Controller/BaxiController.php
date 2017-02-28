<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaxiController extends MainController
{
    /**
     * @Route("/baxi", name="baxi")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
    	$page = $em->getRepository('AppBundle\Entity\Page\Page')->findBy(['slug'=>'baxi']);
    	if(is_array($page) && count($page) <= 0 ){
    		throw new NotFoundHttpException('Sorry not existing!');
    	} else {
    		$page = $page[0];
    	}
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
    	$em = $this->getDoctrine()->getManager();
    	$page = $em->getRepository('AppBundle\Entity\Page\Page')->findBy(['slug'=>'baxi']);
    	if(is_array($page) && count($page) <= 0 ){
    		throw new NotFoundHttpException('Sorry not existing!');
    	} else {
    		$page = $page[0];
    	}
    	$array_twig = $this->defaultInfo($request);
        $this->trackVisit();

        $array_twig['id_page'] = 'baxi';
        return $this->render('AppBundle:baxi:baxi-tc.html.twig',$array_twig);
    }
}
