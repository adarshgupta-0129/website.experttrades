<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;

class GalleryController extends MainController
{
    /**
     * @Route("/gallery/{page}", name="gallery", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $gallery =  $em->getRepository('AppBundle\Entity\Gallery\Gallery')->find(1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $items = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->getForDisplay(10, $offset);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        return $this->render('AppBundle:gallery:index.html.twig',
         array(
           'page' => $page,
           'website' => $website,
           'gallery' => $gallery,
           'items' => $items,
           'footer_images' => $footerImages,
           'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()));
    }
}
