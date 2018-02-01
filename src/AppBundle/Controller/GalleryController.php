<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class GalleryController extends MainController {

    /**
     * @Route("/gallery/{page}", name="gallery", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function indexAction(Request $request, $page) {
        $em = $this->getDoctrine()->getManager();
        $array_twig = $this->defaultInfo($request);

        $selected_tag = $request->query->get('tag');
        $tags = $em->getRepository('AppBundle\Entity\Gallery\Tag\Tag')->getForDisplay();
        $gallery = $em->getRepository('AppBundle\Entity\Gallery\Gallery')->find(1);
        $total_landscape = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->total_landscape();
        $total_portrait = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->total_portrait();
        //var_dump($total_portrait.'::'.$total_landscape);die();

        if ($total_portrait == 0) {
            $perPage = 9;
            $landscape = true;
            $portrait = false;
        } elseif ($total_landscape == 0) {
            $perPage = 8;
            $landscape = false;
            $portrait = true;
        } else {
            $perPage = 9;
            $landscape = false;
            $portrait = false;
        }


        $offset = ($page - 1) * $perPage;
        $filters = [];
        if (isset($selected_tag) && !is_null($selected_tag) && is_numeric($selected_tag)) {
            $filters['tags'] = [$selected_tag];
        }
        $items = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->getForDisplay($perPage, $offset, $filters);
        $this->trackVisit();
        $pos_items = [];
        if (!$landscape && !$portrait) {
            $portraidc = 0;
            $landscapec = 0;
            $count = 0;
            foreach ($items['data'] as $key => $value) {
                if ($value->getWidth() >= $value->getHeight() || ($value->getWidth() == 0 && $value->getHeight() == 0)) {
                    $landscapec++;
                    $pos_items[$key] = 'landscape';
                } else {
                    $portraidc++;
                    $pos_items[$key] = 'portrait';
                }
                $count++;
            }
        }

        $array_twig['id_page'] = 'gallery_page';
        $array_twig['gallery'] = $gallery;
        $array_twig['items'] = $items;
        $array_twig['pos_items'] = $pos_items;
        $array_twig['portrait'] = $portrait;
        $array_twig['landscape'] = $landscape;
        $array_twig['page'] = $page;
        $array_twig['tags'] = $tags;
        $array_twig['selected_tag'] = $selected_tag;
        return $this->render('AppBundle:gallery:index.html.twig', $array_twig);
    }

    /**
     * @Route("/gallery_ajax", name="gallery_ajax")
     */
    public function ajaxAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $array_twig = [];
        $selected_tag = $request->query->get('tag');
        $page = $request->query->get('page');
        $gallery = $em->getRepository('AppBundle\Entity\Gallery\Gallery')->find(1);
        $total_landscape = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->total_landscape();
        $total_portrait = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->total_portrait();
        //var_dump($total_portrait.'::'.$total_landscape);die();
        if ($total_portrait == 0) {
            $perPage = 9;
            $landscape = true;
            $portrait = false;
        } elseif ($total_landscape == 0) {
            $perPage = 8;
            $landscape = false;
            $portrait = true;
        } else {
            $perPage = 9;
            $landscape = false;
            $portrait = false;
        }

        $offset = ($page - 1) * $perPage;
        $filters = [];
        if (isset($selected_tag) && !is_null($selected_tag) && is_numeric($selected_tag)) {
            $filters['tags'] = [$selected_tag];
        }
        $items = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->getForDisplay($perPage, $offset, $filters);
        $pos_items = [];
        if (!$landscape && !$portrait) {
            $portraidc = 0;
            $landscapec = 0;
            $count = 0;
            foreach ($items['data'] as $key => $value) {
                if ($value->getWidth() >= $value->getHeight() || ($value->getWidth() == 0 && $value->getHeight() == 0)) {
                    $landscapec++;
                    $pos_items[$key] = 'landscape';
                } else {
                    $portraidc++;
                    $pos_items[$key] = 'portrait';
                }
                $count++;
            }
        }


        $array_twig['items'] = $items;
        $array_twig['gallery'] = $gallery;
        $array_twig['pos_items'] = $pos_items;
        $array_twig['portrait'] = $portrait;
        $array_twig['landscape'] = $landscape;
        return $this->render('AppBundle:gallery:ajax.html.twig', $array_twig);
    }

}
