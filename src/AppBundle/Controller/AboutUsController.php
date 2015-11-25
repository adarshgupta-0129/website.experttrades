<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use AppBundle\Entity\Subscriber\Subscriber;

class AboutUsController extends MainController
{
    /**
     * @Route("/about-us", name="about-us")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $aboutUs =  $em->getRepository('AppBundle\Entity\AboutUs\AboutUs')->find(1);
        $teamMembers =  $em->getRepository('AppBundle\Entity\TeamMember\TeamMember')->findAll();
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);

        $this->trackVisit();

        return $this->render('AppBundle:about_us:index.html.twig',
        array(
         'website' => $website,
         'aboutUs' => $aboutUs,
         'teamMembers' => $teamMembers,
         'footer_images' => $footerImages,
         'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
         'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
       ));
    }
}
