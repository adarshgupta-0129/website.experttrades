<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;

class BlogController extends MainController
{
      /**
     * @Route("/blog/{slug}", name="post", requirements={"slug" = "\w+"}, defaults={"slug" = ""})
     */
    public function indexAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $post = $em->getRepository('AppBundle\Entity\Blog\Post\Post')->findBy(['slug'=>$slug]);

        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:post:index.html.twig',
         array(
           'website' => $website,
           'blog' => $blog,
           'post' => $post,
           'footer_images' => $footerImages,
           'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
           'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()));
    }
}
