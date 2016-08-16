<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Item\Item;

class MessageController extends MainController
{
    /**
     * @Route("/message-success", name="message_success")
     */
    public function messageSuccessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $facebook = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_FB]);
    	$twitter = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_TWITTER]);
    	$favicon = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_FAVICON]);
      $facebook_image = null;
      $twitter_image = null;
    	if(is_object($facebook))$facebook_image =( is_null($facebook->getPath())) ? null : $facebook->getWebPath();
    	if(is_object($twitter))$twitter_image = ( is_null($twitter->getPath())) ? null : $twitter->getWebPath();
    	if(is_object($favicon))$favicon = ( is_null($favicon->getPath())) ? null : $favicon->getWebPath();
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);

        return $this->render('AppBundle:message:success.html.twig',
        array(
          'website' => $website,
           'hasBlog' => $blog->getActive(),
        		'favicon' => $favicon,
        		'facebook_image' => $facebook_image,
        		'twitter_image' => $twitter_image,
           'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
          'footer_images' => $footerImages,
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll()
        ));
    }
}
