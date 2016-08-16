<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class PostController extends MainController
{
      /**
     * @Route("/blog/post/{slug}", name="post",  defaults={"slug" = ""})
     */
    public function indexAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $facebook = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_FB]);
        $twitter = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_TWITTER]);
        $favicon = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_FAVICON]);
        $facebook_image = null;
        $twitter_image = null;
        if(is_object($facebook))$facebook_image =( is_null($facebook->getPath())) ? null : $facebook->getWebPath();
        if(is_object($twitter))$twitter_image = ( is_null($twitter->getPath())) ? null : $twitter->getWebPath();
        if(is_object($favicon))$favicon = ( is_null($favicon->getPath())) ? null : $favicon->getWebPath();
        $post = $em->getRepository('AppBundle\Entity\Blog\Post\Post')->findBy(['slug'=>$slug]);
        if(is_array($post) && count($post) <= 0 ){
        	return $this->redirect($this->generateUrl('blog'),404);
        } else {
        	$post = $post[0];
        }

        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:blog/post:index.html.twig',
         array(
           'website' => $website,
           'blog' => $blog,
           'hasBlog' => $blog->getActive(),
         'homepage' => $homepage,
        		'favicon' => $favicon,
        		'facebook_image' => $facebook_image,
        		'twitter_image' => $twitter_image,
           'post' => $post,
           'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
           'footer_images' => $footerImages,
           'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
           'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()));
    }
}
