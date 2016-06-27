<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;

class BlogController extends MainController
{
    /**
     * @Route("/blog/posts/{page}", name="blog", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $search = "";


        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;
        if( !is_null($request->query->get('search'))){
        	$search = $request->query->get('search');
        	$posts = $em->getRepository('AppBundle\Entity\Blog\Post\Post')->getPaginated($perPage, $offset, array('search' => $search ));
        }
        else
        {
        	$posts = $em->getRepository('AppBundle\Entity\Blog\Post\Post')->getPaginated($perPage, $offset, array('search' => $search));
        }

        if( $page > $posts['last_page'] ){
        	return $this->redirect($this->generateUrl('blog'));
        }


        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:blog:index.html.twig',
         array(
         	'search' => $search,
           'page' => $page,
           'website' => $website,
           'hasBlog' => $blog->getActive(),
           'blog' => $blog,
           'posts' => $posts,
           'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['id' => 'DESC']),
           'footer_images' => $footerImages,
           'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
           'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()));
    }
}
