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
        } else{
        	$page = $page[0];
        }

        if( $page->getType() == 0 ){
          $this->trackVisit();
          $array_twig = $this->defaultInfo($request);
          //var_dump($page);
          $array_twig['id_page'] = $page->getSlug();
          $array_twig['page'] = $page;
          return $this->render('AppBundle:page:index.html.twig',$array_twig);
        } else if($page->getType() == 1){
          $url = $page->getUrlRedirection();
          if( strpos(strtolower($url), 'http') !== FALSE )
            return $this->redirect($url);
          else {
            if( substr($url,0,1) == "/" ){
               $url = substr($url,1);
            }
              return $this->redirect($this->generateUrl('page').$url);
          }

        }
    }

  /**
   * @Route("/{slug}/{slug2}", name="page2",  defaults={"slug" = "","slug2" = ""})
   */
  public function index2Action(Request $request, $slug, $slug2)
  {
      $slug = $slug."/".$slug2;
      $em = $this->getDoctrine()->getManager();
      $page = $em->getRepository('AppBundle\Entity\Page\Page')->findBy(['slug'=>$slug]);
      if(is_array($page) && count($page) <= 0 ){
          throw new NotFoundHttpException('Sorry this page did not exist!');
      } else {
        $page = $page[0];
      }

      if( $page->getType() == 0 ){
        $this->trackVisit();
        $array_twig = $this->defaultInfo($request);
        //var_dump($page);
        $array_twig['id_page'] = $page->getSlug();
        $array_twig['page'] = $page;
        return $this->render('AppBundle:page:index.html.twig',$array_twig);
      } else if($page->getType() == 1){
        $url = $page->getUrlRedirection();
        if( strpos(strtolower($url), 'http') !== FALSE )
          return $this->redirect($url);
        else {
          if( substr($url,0,1) == "/" ){
             $url = substr($url,1);
          }
            return $this->redirect($this->generateUrl('page').$url);
        }

      }
  }

  /**
   * @Route("/{slug}/{slug2}/{slug3}", name="page3",  defaults={"slug" = "","slug2" = "","slug3" = ""})
   */
  public function index3Action(Request $request, $slug, $slug2, $slug3)
  {
      $slug = $slug."/".$slug2."/".$slug3;
      $em = $this->getDoctrine()->getManager();

      $page = $em->getRepository('AppBundle\Entity\Page\Page')->findBy(['slug'=>$slug]);
      if(is_array($page) && count($page) <= 0 ){
          throw new NotFoundHttpException('Sorry this page did not exist!');
      } else {
        $page = $page[0];
      }

      if( $page->getType() == 0 ){
        $this->trackVisit();
        $array_twig = $this->defaultInfo($request);
        //var_dump($page);
        $array_twig['id_page'] = $page->getSlug();
        $array_twig['page'] = $page;
        return $this->render('AppBundle:page:index.html.twig',$array_twig);
      } else if($page->getType() == 1){
        $url = $page->getUrlRedirection();
        if( strpos(strtolower($url), 'http') !== FALSE )
          return $this->redirect($url);
        else {
          if( substr($url,0,1) == "/" ){
             $url = substr($url,1);
          }
            return $this->redirect($this->generateUrl('page').$url);
        }

      }
  }
}
