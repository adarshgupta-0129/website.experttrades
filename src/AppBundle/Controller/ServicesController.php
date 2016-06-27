<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Subscriber\Subscriber;

class ServicesController extends MainController
{
    /**
     * @Route("/services", name="services")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);
        $items = $em->getRepository('AppBundle\Entity\Service\Item\Item')->getForDisplay();
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:services:index.html.twig',
        array(
          'website' => $website,
           'hasBlog' => $blog->getActive(),
          'service' => $service,
          'items' => $items,
          'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['id' => 'DESC']),
          'footer_images' => $footerImages,
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }

    /**
     * @Route("/services/{slug}", name="services_view")
     */
    public function serviceAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);
        $item = $em->getRepository('AppBundle\Entity\Service\Item\Item')->findOneBy([
          'page_slug' => $slug,
          'page_active' => true
        ]);

        if(!is_object($item)){
            throw new NotFoundHttpException("Page not found");
        }

        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:services/view:index.html.twig',
        array(
          'website' => $website,
          'hasBlog' => $blog->getActive(),
          'service' => $service,
          'item' => $item,
          'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['id' => 'DESC']),
          'footer_images' => $footerImages,
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }
}
