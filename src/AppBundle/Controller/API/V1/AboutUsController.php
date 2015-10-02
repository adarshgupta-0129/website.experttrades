<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AboutUsController extends SecurityController
{
    /**
     * @Route("/api/v1/about_us", name="get_about_us")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $aboutUs =  $em->getRepository('AppBundle\Entity\AboutUs\AboutUs')->find(1);

        $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/images/about_us/';
        if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
              $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/about_us/';
        }

        $response = new Response(json_encode(
        [

          'header_text' => $aboutUs->getHeaderText(),
          'header_title' => $aboutUs->getHeaderTitle(),

          'about_us_title' => $aboutUs->getAboutUsTitle(),
          'about_us_text' => $aboutUs->getAboutUsText(),

          'about_us_first_point_title' => $aboutUs->getAboutUsFirstPointTitle(),
          'about_us_first_point_text' => $aboutUs->getAboutUsFirstPointText(),
          'about_us_first_point_image' => $aboutUs->getAboutUsFirstPointImage(),

          'about_us_second_point_title' => $aboutUs->getAboutUsSecondPointTitle(),
          'about_us_second_point_text' => $aboutUs->getAboutUsSecondPointText(),
          'about_us_second_point_image' => $aboutUs->getAboutUsSecondPointImage(),

          'about_us_third_point_title' => $aboutUs->getAboutUsThirdPointTitle(),
          'about_us_third_point_text' => $aboutUs->getAboutUsThirdPointText(),
          'about_us_third_point_image' => $aboutUs->getAboutUsThirdPointImage(),

          'image_url' => (is_null($aboutUs->getPath())) ? null : $slidersPath.$aboutUs->getPath(),

          'statistics_title' => $aboutUs->getStatisticsTitle(),

          'statistics_first_box_number' => $aboutUs->getStatisticsFirstBoxNumber(),
          'statistics_first_box_text' => $aboutUs->getStatisticsFirstBoxText(),

          'statistics_second_box_number' => $aboutUs->getStatisticsSecondBoxNumber(),
          'statistics_second_box_text' => $aboutUs->getStatisticsSecondBoxText(),

          'statistics_third_box_number' => $aboutUs->getStatisticsThirdBoxNumber(),
          'statistics_third_box_text' => $aboutUs->getStatisticsThirdBoxText(),

          'statistics_fourth_box_number' => $aboutUs->getStatisticsFourthBoxNumber(),
          'statistics_fourth_box_text' => $aboutUs->getStatisticsFourthBoxText(),
          'meta_title' => $aboutUs->getMetaTitle(),
          'meta_description' => $aboutUs->getMetaDescription()

        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/about_us", name="put_about_us")
     * @Method({"PUT"})
     */
    public function postAction(Request $request)
    {
        $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();
         $aboutUs =  $em->getRepository('AppBundle\Entity\AboutUs\AboutUs')->find(1);

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['header_title'])){
               $aboutUs->setHeaderTitle($params['header_title']);
             }
             if(isset($params['header_text'])){
               $aboutUs->setHeaderText($params['header_text']);
             }

             if(isset($params['about_us_title'])){
               $aboutUs->setAboutUsTitle($params['about_us_title']);
             }
             if(isset($params['about_us_text'])){
               $aboutUs->setAboutUsText($params['about_us_text']);
             }

             if(isset($params['about_us_first_point_title'])){
               $aboutUs->setAboutUsFirstPointTitle($params['about_us_first_point_title']);
             }
             if(isset($params['about_us_first_point_text'])){
               $aboutUs->setAboutUsFirstPointText($params['about_us_first_point_text']);
             }
             if(isset($params['about_us_first_point_image'])){
               $aboutUs->setAboutUsFirstPointImage($params['about_us_first_point_image']);
             }

             if(isset($params['about_us_second_point_title'])){
               $aboutUs->setAboutUsSecondPointTitle($params['about_us_second_point_title']);
             }
             if(isset($params['about_us_second_point_text'])){
               $aboutUs->setAboutUsSecondPointText($params['about_us_second_point_text']);
             }
             if(isset($params['about_us_second_point_image'])){
               $aboutUs->setAboutUsSecondPointImage($params['about_us_second_point_image']);
             }

             if(isset($params['about_us_third_point_title'])){
               $aboutUs->setAboutUsThirdPointTitle($params['about_us_third_point_title']);
             }
             if(isset($params['about_us_third_point_text'])){
               $aboutUs->setAboutUsThirdPointText($params['about_us_third_point_text']);
             }
             if(isset($params['about_us_third_point_image'])){
               $aboutUs->setAboutUsThirdPointImage($params['about_us_third_point_image']);
             }

             if(isset($params['statistics_title'])){
               $aboutUs->setStatisticsTitle($params['statistics_title']);
             }

             if(isset($params['statistics_first_box_number'])){
               $aboutUs->setStatisticsFirstBoxNumber($params['statistics_first_box_number']);
             }
             if(isset($params['statistics_first_box_text'])){
               $aboutUs->setStatisticsFirstBoxText($params['statistics_first_box_text']);
             }

             if(isset($params['statistics_second_box_number'])){
               $aboutUs->setStatisticsSecondBoxNumber($params['statistics_second_box_number']);
             }
             if(isset($params['statistics_second_box_text'])){
               $aboutUs->setStatisticsSecondBoxText($params['statistics_second_box_text']);
             }

             if(isset($params['statistics_third_box_number'])){
               $aboutUs->setStatisticsThirdBoxNumber($params['statistics_third_box_number']);
             }
             if(isset($params['statistics_third_box_text'])){
               $aboutUs->setStatisticsThirdBoxText($params['statistics_third_box_text']);
             }

             if(isset($params['statistics_fourth_box_number'])){
               $aboutUs->setStatisticsFourhtBoxNumber($params['statistics_fourth_box_number']);
             }
             if(isset($params['statistics_fourth_box_text'])){
               $aboutUs->setStatisticsFourthBoxText($params['statistics_fourth_box_text']);
             }

             if(isset($params['meta_title'])){
               $aboutUs->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $aboutUs->setMetaDescription($params['meta_description']);
             }

             $em->persist($aboutUs);
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
     * @Route("/api/v1/about_us_image", name="post_contact_image")
     * @Method({"POST"})
     */
    public function postImageAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $aboutUs =  $em->getRepository('AppBundle\Entity\AboutUs\AboutUs')->find(1);

        $file = $request->files->get('file');
        if(!is_null($file)) {

          $aboutUs->deleteFile();
          $aboutUs->setFile($file);
          $aboutUs->upload();
          $em->persist($aboutUs);
          $em->flush();

          $response = new Response(json_encode(
          [
            'code' => 200,
            'message' => 'OK'
          ]));

          $response->headers->set('Content-Type', 'application/json');
          return $response;

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
