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
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $facebook = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_FB]);
    	$twitter = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_TWITTER]);
    	$favicon = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_FAVICON]);
    	if(is_object($facebook))$facebook_image =( is_null($facebook->getPath())) ? null : $facebook->getWebPath();
    	if(is_object($twitter))$twitter_image = ( is_null($twitter->getPath())) ? null : $twitter->getWebPath();
    	if(is_object($favicon))$favicon = ( is_null($favicon->getPath())) ? null : $favicon->getWebPath();
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $items = $em->getRepository('AppBundle\Entity\Review\Item\Item')->getForDisplay(10, $offset);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:reviews:index.html.twig',
        array(
          'page' => $page,
          'website' => $website,
           'hasBlog' => $blog->getActive(),
         'homepage' => $homepage,
        		'favicon' => $favicon,
        		'facebook_image' => $facebook_image,
        		'twitter_image' => $twitter_image,
          'review' => $review,
          'items' => $items,
          'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
          'footer_images' => $footerImages,
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }

    /**
     * @Route("/review/{id}", name="review_view")
     */
    public function viewAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $facebook = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_FB]);
    	$twitter = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_TWITTER]);
    	$favicon = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_FAVICON]);
    	if(is_object($facebook))$facebook_image =( is_null($facebook->getPath())) ? null : $facebook->getWebPath();
    	if(is_object($twitter))$twitter_image = ( is_null($twitter->getPath())) ? null : $twitter->getWebPath();
    	if(is_object($favicon))$favicon = ( is_null($favicon->getPath())) ? null : $favicon->getWebPath();
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);
        $item = $em->getRepository('AppBundle\Entity\Review\Item\Item')->find($id);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:reviews:view.html.twig',
        array(
          'website' => $website,
           'hasBlog' => $blog->getActive(),
         'homepage' => $homepage,
        		'favicon' => $favicon,
        		'facebook_image' => $facebook_image,
        		'twitter_image' => $twitter_image,
          'review' => $review,
          'item' => $item,
          'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
          'footer_images' => $footerImages,
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }
}
