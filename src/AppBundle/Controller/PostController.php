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
       $post = $em->getRepository('AppBundle\Entity\Blog\Post\Post')->findBy(['slug'=>$slug]);
        if(is_array($post) && count($post) <= 0 ){
        	return $this->redirect($this->generateUrl('blog'),404);
        } else {
        	$post = $post[0];
        }

        $this->trackVisit();
        $array_twig = $this->defaultInfo($request);
        
        $array_twig['post'] = $post;
        $array_twig['blog'] = $blog;
        return $this->render('AppBundle:blog/post:index.html.twig',$array_twig);
        /*
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
           'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()));*/
    }
}
