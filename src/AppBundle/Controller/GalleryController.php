<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends Controller
{
    /**
     * @Route("/gallery", name="gallery")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $gallery =  $em->getRepository('AppBundle\Entity\Gallery\Gallery')->find(1);
        $items = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->getForDisplay();
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'ASC'], 9, 0);

        return $this->render('AppBundle:gallery:index.html.twig', array('website' => $website, 'gallery' => $gallery, 'items' => $items, 'footer_images' => $footerImages));
    }
}
