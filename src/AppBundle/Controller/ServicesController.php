<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class ServicesController extends MainController
{
    /**
     * @Route("/services/{page}", name="services", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);
        //$items = $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy([],['id' => 'DESC']);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;
        $items = $em->getRepository('AppBundle\Entity\Service\Item\Item')->getPaginated($perPage, $offset, 'order');

        if( $page > $items['last_page'] ){
        	return $this->redirect($this->generateUrl('blog'));
        }
        $this->trackVisit();
        $array_twig = $this->defaultInfo($request);

        $array_twig['id_page'] = 'services_page';
        $array_twig['service'] = $service;
        $array_twig['items'] = $items;
        $array_twig['page'] = $page;
        return $this->render('AppBundle:services:index.html.twig',$array_twig);
      /*  array(
          'website' => $website,
           'hasBlog' => $blog->getActive(),
         'homepage' => $homepage,
        		'favicon' => $favicon,
        		'facebook_image' => $facebook_image,
        		'twitter_image' => $twitter_image,
          'service' => $service,
          'items' => $items,
           'page' => $page,
          'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
          'footer_images' => $footerImages,
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));*/
    }

    /**
     * @Route("/services/{slug}", name="services_view")
     */
    public function serviceAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);
        $item = $em->getRepository('AppBundle\Entity\Service\Item\Item')->findOneBy([
          'page_slug' => $slug,
          'page_active' => true
        ]);

        if(!is_object($item)){
            throw new NotFoundHttpException("Page not found");
        }


        $this->trackVisit();
        $array_twig = $this->defaultInfo($request);

        $array_twig['id_page'] = 'services_page';
        $array_twig['service'] = $service;
        $array_twig['item'] = $item;
        $array_twig['page'] = $page;
        return $this->render('AppBundle:services:index.html.twig',$array_twig);
        /*return $this->render('AppBundle:services/view:index.html.twig',
        array(
          'website' => $website,
          'hasBlog' => $blog->getActive(),
         'homepage' => $homepage,
        		'favicon' => $favicon,
        		'facebook_image' => $facebook_image,
        		'twitter_image' => $twitter_image,
          'service' => $service,
          'item' => $item,
          'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
          'footer_images' => $footerImages,
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));*/
    }
}
