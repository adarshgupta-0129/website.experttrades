<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;

class GalleryController extends MainController
{
    /**
     * @Route("/gallery/{page}", name="gallery", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $gallery =  $em->getRepository('AppBundle\Entity\Gallery\Gallery')->find(1);
        $total_landscape = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->total_landscape();
        $total_portrait =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->total_portrait();
        //var_dump($total_portrait.'::'.$total_landscape);die();
        if(	$total_portrait  == 0 ){
        	$perPage = 9;
        	$landscape = true;
        	$portrait = false;
        }
        elseif ( $total_landscape == 0 )
        {
        	$perPage = 8;
        	$landscape = false;
        	$portrait = true;
        }
        else
        {
        	$perPage = 9;
        	$landscape = false;
        	$portrait = false;
        }

        $offset = ($page - 1) * $perPage;
        $items = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->getForDisplay($perPage, $offset);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();
        $pos_items= [];
        if(!$landscape && !$portrait ) {
	        $portraidc = 0;
	        $landscapec = 0;
        	$count = 0;
        	foreach ($items['data'] as $key => $value ){
        		if($value->getWidth() >= $value->getHeight() || ($value->getWidth() == 0 && $value->getHeight() == 0)){
        			$landscapec++;
        			$pos_items[$key] = 'landscape';
        		} else {
        			$portraidc++;
        			$pos_items[$key] = 'portrait';
        		}
        		$count++;
        	}
        }

        return $this->render('AppBundle:gallery:index.html.twig',
         array(
           'page' => $page,
           'website' => $website,
           'hasBlog' => $blog->getActive(),
           'gallery' => $gallery,
           'items' => $items,
           'pos_items' => $pos_items,
           'portrait' => $portrait,
           'landscape' => $landscape,
           'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['id' => 'DESC']),
           'footer_images' => $footerImages,
           'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
           'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()));
    }
}
