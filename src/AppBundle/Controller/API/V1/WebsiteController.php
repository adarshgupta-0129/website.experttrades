<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WebsiteController extends SecurityController
{
    /**
     * @Route("/api/v1/website", name="get_logo")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $website = $em->getRepository('AppBundle\Entity\Website')->find(1);

        $path = 'http://'.$request->server->get('HTTP_HOST').'/images/logo/';
        if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
              $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/logo/';
        }

        $response = new Response(json_encode([
          'facebook_link' => $website->getFacebookLink(),
          'twitter_link' => $website->getTwitterLink(),
          'youtube_link' => $website->getYoutubeLink(),
          'google_link' => $website->getGoogleLink(),
          'linkedin_link' => $website->getGoogleLink(),
          'facebook_link_enabled' => $website->getFacebookLinkEnabled(),
          'twitter_link_enabled' => $website->getTwitterLinkEnabled(),
          'youtube_link_enabled' => $website->getYoutubeLinkEnabled(),
          'google_link_enabled' => $website->getGoogleLinkEnabled(),
          'linkedin_link_enabled' => $website->getLinkedinLinkEnabled(),
          'postcode' => $website->getPostcode(),
          'subscribe_title' => $website->getSubscribeTitle(),
          'subscribe_subtitle' => $website->getSubscribeSubtitle(),
          'copyright' => $website->getCopyright(),
          'company_name' => $website->getCompanyName(),
          'show_logo' => $website->getShowLogo(),
          'logo_url' => (is_null($website->getLogoPath())) ? null : $path.$website->getLogoPath(),

        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/website", name="put_website")
     * @Method({"PUT"})
     */
    public function putAction(Request $request)
    {
         $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();
         $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['facebook_link'])){
               $website->setFacebookLink($params['facebook_link']);
             }
             if(isset($params['twitter_link'])){
               $website->setTwitterLink($params['twitter_link']);
             }
             if(isset($params['youtube_link'])){
               $website->setYoutubeLink($params['youtube_link']);
             }
             if(isset($params['google_link'])){
               $website->setGoogleLink($params['google_link']);
             }
             if(isset($params['linkedin_link'])){
               $website->setLinkedinLink($params['linkedin_link']);
             }

             if(isset($params['facebook_link_enabled'])){
               $website->setFacebookLinkEnabled($params['facebook_link_enabled']);
             }
             if(isset($params['twitter_link_enabled'])){
               $website->setTwitterLinkEnabled($params['twitter_link_enabled']);
             }
             if(isset($params['youtube_link_enabled'])){
               $website->setYoutubeLinkEnabled($params['youtube_link_enabled']);
             }
             if(isset($params['google_link_enabled'])){
               $website->setGoogleLinkEnabled($params['google_link_enabled']);
             }
             if(isset($params['linkedin_link_enabled'])){
               $website->setLinkedinLinkEnabled($params['linkedin_link_enabled']);
             }

             if(isset($params['postcode'])){
               $website->setPostcode($params['postcode']);
             }
             if(isset($params['subscribe_title'])){
               $website->setSubscribeTitle($params['subscribe_title']);
             }
             if(isset($params['subscribe_subtitle'])){
               $website->setSubscribeSubtitle($params['subscribe_subtitle']);
             }
             if(isset($params['copyright'])){
               $website->setCopyright($params['copyright']);
             }
             if(isset($params['company_name'])){
               $website->setCompanyName($params['company_name']);
             }
             if(isset($params['show_logo'])){
               $website->setShowLogo($params['show_logo']);
             }

             $em->persist($website);
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
     * @Route("/api/v1/website_logo", name="post_website_logo")
     * @Method({"POST"})
     */
    public function postLogoAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $website = $em->getRepository('AppBundle\Entity\Website')->find(1);

        $file = $request->files->get('file');
        if(!is_null($file)) {

          $website->deleteLogoFile();
          $website->setLogoFile($file);
          $website->logoUpload();
          $em->persist($website);
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
