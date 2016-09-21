<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Visit\Visit;
use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class MainController extends Controller
{
	
	
    public function trackVisit()
    {
        $em = $this->getDoctrine()->getManager();

  /*   NOT A GOOD WAY TO TRACK VISITS, TO MANY ROWS IN DB AND NOT ACCURATE
     if(!isset($_COOKIE['visit'])) {

            setcookie('visit', '1', time() + 86400, "/");

            $visit = new Visit();
            $visit->setIp();
            $em->persist($visit);
            $em->flush();

        }
        */
    }
    
    public function defaultInfo()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	
    	$website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
    	$blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
    	$homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);
    	$footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
    	$facebook = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_FB]);
    	$twitter = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_TWITTER]);
    	$favicon = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_FAVICON]);
    	$facebook_image = null;
    	$twitter_image = null;
    	if(is_object($facebook))$facebook_image =( is_null($facebook->getPath())) ? null : $facebook->getWebPath();
    	if(is_object($twitter))$twitter_image = ( is_null($twitter->getPath())) ? null : $twitter->getWebPath();
    	if(is_object($favicon))$favicon = ( is_null($favicon->getPath())) ? null : $favicon->getWebPath();

    	return array(
    			'website' => $website,
    			'homepage' => $homepage,
    			'favicon' => $favicon,
    			'facebook_image' => $facebook_image,
    			'twitter_image' => $twitter_image,
    			'hasBlog' => $blog->getActive(),
    			'footer_images' => $footerImages,
    			'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
    			'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
           		'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
    	);
    }
}
