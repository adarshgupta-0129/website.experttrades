<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ZPageController extends MainController
{
      /**
     * @Route("/{slug}", name="page",  defaults={"slug" = ""})
     */
    public function indexAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('AppBundle\Entity\Page\Page')->findBy(['slug'=>$slug]);
        if(is_array($page) && count($page) <= 0 ){
    		throw new NotFoundHttpException('Sorry this page did not exist!');
        } else {
        	$page = $page[0];
        }

        $this->trackVisit();
        $array_twig = $this->defaultInfo($request);
        //var_dump($page);
        $array_twig['id_page'] = $page->getSlug();
        $array_twig['page'] = $page;
        return $this->render('AppBundle:page:index.html.twig',$array_twig);
    }
}
