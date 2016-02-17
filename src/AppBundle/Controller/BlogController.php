<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;

class BlogController extends MainController
{
    /**
     * @Route("/blog/{page}", name="blog", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;
        $posts = $em->getRepository('AppBundle\Entity\Blog\Post\Post')->getPaginated($perPage, $offset);

        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:blog:index.html.twig',
         array(
           'page' => $page,
           'website' => $website,
           'blog' => $blog,
           'posts' => $posts,
           'footer_images' => $footerImages,
           'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
           'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()));
    }
}
