<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

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

        $array_twig = $this->defaultInfo($request);


        $this->trackVisit();

        $array_twig['id_page'] = 'blog_page';
        $array_twig['search'] = $search;
        $array_twig['page'] = $page;
        $array_twig['blog'] = $blog;
        $array_twig['posts'] = $posts;
        return $this->render('AppBundle:blog:index.html.twig',$array_twig);
    }
}
