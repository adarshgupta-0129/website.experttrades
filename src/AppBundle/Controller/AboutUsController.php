<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class AboutUsController extends MainController
{
    /**
     * @Route("/about-us", name="about-us")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $aboutUs =  $em->getRepository('AppBundle\Entity\AboutUs\AboutUs')->find(1);
    	$teamMembers =  $em->getRepository('AppBundle\Entity\TeamMember\TeamMember')->findAll();
    	$array_twig = $this->defaultInfo();
        $this->trackVisit();

        $array_twig['aboutUs'] = $aboutUs;
        $array_twig['teamMembers'] = $teamMembers;
    	$array_twig['subscriber_form'] =  $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView();
        return $this->render('AppBundle:about_us:index.html.twig',$array_twig);
    }
}
