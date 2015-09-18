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
        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);

        return $this->render('AppBundle:homepage:index.html.twig', array('homepage' => $homepage));
    }
}
