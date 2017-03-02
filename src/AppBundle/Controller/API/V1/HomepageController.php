<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Homepage\Slider\Slider;

class HomepageController extends SecurityController
{
    /**
     * @Route("/api/v1/homepage", name="get_homepage")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);

        $this->checkAccess($request);

        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);

        $path = 'http://'.$request->server->get('HTTP_HOST').'/images/homepage/sliders/';
        if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
              $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/homepage/sliders/';
        }
        $slidersArray = [];
        foreach($homepage->getSliders() as $slider){
            $slidersArray[] = [
              'id' => $slider->getId(),
              'title' => $slider->getTitle(),
              'subtitle' => $slider->getSubtitle(),
              'image_url' => $path.$slider->getPath(),
              'button_text' => $slider->getButtonText(),
              'url' => $slider->getUrl(),
              'button_text2' => $slider->getButtonText2(),
              'url2' => $slider->getUrl2(),
              'button_text3' => $slider->getButtonText3(),
              'url3' => $slider->getUrl3()
            ];
        }

        $response = new Response(json_encode(
        [
          'sliders' => $slidersArray,
          'reviews_title' => $homepage->getReviewsTitle(),
          'reviews_subtitle' => $homepage->getReviewsSubtitle(),
          'services_title' => $homepage->getServicesTitle(),
          'services_subtitle' => $homepage->getServicesSubtitle(),
          'gallery_title' => $homepage->getGalleryTitle(),
          'gallery_subtitle' => $homepage->getGallerySubtitle(),
          'contact_us_title' => $homepage->getContactUsTitle(),
          'contact_us_subtitle' => $homepage->getContactUsSubtitle(),
          'find_me_on_title' => $homepage->getFindMeOnTitle(),
          'find_me_on_subtitle' => $homepage->getFindMeOnSubtitle(),
          'meta_title' => $homepage->getMetaTitle(),
          'meta_description' => $homepage->getMetaDescription(),
          'slider_type' => $homepage->getSliderType()
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/homepage", name="post_homepage")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
         $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);

         $this->checkAccess($request);

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['reviews_title'])){
                 $homepage->setReviewsTitle($params['reviews_title']);
             }
             if(isset($params['reviews_subtitle'])){
                 $homepage->setReviewsSubtitle($params['reviews_subtitle']);
             }
             if(isset($params['services_title'])){
                 $homepage->setServicesTitle($params['services_title']);
             }
             if(isset($params['services_subtitle'])){
                 $homepage->setServicesSubtitle($params['services_subtitle']);
             }
             if(isset($params['gallery_title'])){
                 $homepage->setGalleryTitle($params['gallery_title']);
             }
             if(isset($params['gallery_subtitle'])){
                 $homepage->setGallerySubtitle($params['gallery_subtitle']);
             }
             if(isset($params['contact_us_title'])){
                 $homepage->setContactUsTitle($params['contact_us_title']);
             }
             if(isset($params['contact_us_subtitle'])){
                 $homepage->setContactUsSubtitle($params['contact_us_subtitle']);
             }
             if(isset($params['find_me_on_title'])){
                 $homepage->setFindMeOnTitle($params['find_me_on_title']);
             }
             if(isset($params['find_me_on_subtitle'])){
                 $homepage->setFindMeOnSubtitle($params['find_me_on_subtitle']);
             }

             if(isset($params['meta_title'])){
               $homepage->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $homepage->setMetaDescription($params['meta_description']);
             }
             if(isset($params['slider_type'])){
               $homepage->setSliderType($params['slider_type']);
             }

             $em->persist($homepage);
             $em->flush();

             $response = new Response(json_encode(
             [
               'code' => 200,
               'message' => 'OK'
             ]));

         }else{

             $response = new Response(json_encode(
             [
               'code' => 1,
               'message' => 'Invalid Form'
             ]));
         }

         $response->headers->set('Content-Type', 'application/json');
         return $response;

    }

    /**
     * @Route("/api/v1/homepage_sliders/{id}", name="get_homepage_slider", requirements={"id" = "\d+"}, defaults={"id" = 0})
     * @Method({"GET"})
     */
    public function getSliderAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $slider =  $em->getRepository('AppBundle\Entity\Homepage\Slider\Slider')->find($id);
        if(!is_object($slider)){
            throw new NotFoundHttpException();
        }
        $sliderPath = 'http://'.$request->server->get('HTTP_HOST').'/images/homepage/sliders/';
        if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
              $sliderPath = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/homepage/sliders/';
        }

        $sliderArray = [
          'id' => $slider->getId(),
          'title' => $slider->getTitle(),
          'subtitle' => $slider->getSubtitle(),
          'image_url' => $sliderPath.$slider->getPath(),
              'button_text' => $slider->getButtonText(),
              'url' => $slider->getUrl(),
              'button_text2' => $slider->getButtonText2(),
              'url2' => $slider->getUrl2(),
              'button_text3' => $slider->getButtonText3(),
              'url3' => $slider->getUrl3()
        ];

        $response = new Response(json_encode($sliderArray));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/v1/homepage_sliders/{id}", name="post_homepage_slider", requirements={"id" = "\d+"}, defaults={"id" = 0})
     * @Method({"POST"})
     */
    public function postSliderAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $slider =  $em->getRepository('AppBundle\Entity\Homepage\Slider\Slider')->find($id);
        if(!is_object($slider)){
            throw new NotFoundHttpException();
        }

        $params = array();
        $content = $this->get("request")->getContent();

        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array

            if(isset($params['title'])){
              $slider->setTitle($params['title']);
            }

            if(isset($params['subtitle'])){
              $slider->setSubtitle($params['subtitle']);
            }
            if(isset($params['button_text'])){
              $slider->setButtonText($params['button_text']);
            }
            if(isset($params['url'])){
              $slider->setUrl($params['url']);
            }
            if(isset($params['button_text2'])){
              $slider->setButtonText2($params['button_text2']);
            }
            if(isset($params['url2'])){
              $slider->setUrl2($params['url2']);
            }
            if(isset($params['button_text3'])){
              $slider->setButtonText3($params['button_text3']);
            }
            if(isset($params['url3'])){
              $slider->setUrl3($params['url3']);
            }

            $em->persist($slider);
            $em->flush();

            $response = new Response(json_encode(
            [
              'code' => 200,
              'message' => 'OK'
            ]));

        }else{

            $response = new Response(json_encode(
            [
              'code' => 1,
              'message' => 'Invalid Form'
            ]));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;


     }

    /**
     * @Route("/api/v1/homepage_slider_image/{id}", name="post_homepage_image_slider", requirements={"id" = "\d+"}, defaults={"id" = 0})
     * @Method({"POST"})
     */
    public function postSliderImageAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $slider =  $em->getRepository('AppBundle\Entity\Homepage\Slider\Slider')->find($id);
        if(!is_object($slider)){
            throw new NotFoundHttpException();
        }

        $file = $request->files->get('file');
        if(!is_null($file)) {

          $slider->setFile($file);
          $slider->upload();
          $em->persist($slider);
          $em->flush();

          $response = new Response(json_encode(
          [
            'code' => 200,
            'message' => 'OK'
          ]));

        }else{

            $response = new Response(json_encode(
            [
              'code' => 1,
              'message' => 'Invalid Form'
            ]));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
}
