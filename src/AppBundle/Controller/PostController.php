<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;

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

        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:blog/post:index.html.twig',
         array(
           'website' => $website,
           'blog' => $blog,
           'hasBlog' => $blog->getActive(),
           'post' => $post,
           'footer_images' => $footerImages,
           'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
           'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()));
    }
}
