<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Item\Item;

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
        $response = new Response(json_encode($this->getWebsite($request, $website)));
    	$response->headers->set('Content-Type', 'application/json');

    	return $response;

    }




    private function getWebsite(Request $request, $website){

    	$path_logo = 'http://'.$request->server->get('HTTP_HOST').'/images/logo/';
    	if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
    		$path_logo = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/logo/';
    	}
    	$path = 'http://'.$request->server->get('HTTP_HOST').'/';
    	if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
    		$path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
    	}

    	$response = [
    			'facebook_link' => $website->getFacebookLink(),
    			'twitter_link' => $website->getTwitterLink(),
    			'twitter_page' => $website->getTwitterPage(),
    			'instagram_link' => $website->getInstagramLink(),
    			'youtube_link' => $website->getYoutubeLink(),
    			'google_link' => $website->getGoogleLink(),
    			'linkedin_link' => $website->getLinkedinLink(),
    			'facebook_link_enabled' => $website->getFacebookLinkEnabled(),
    			'twitter_link_enabled' => $website->getTwitterLinkEnabled(),
    			'youtube_link_enabled' => $website->getYoutubeLinkEnabled(),
    			'google_link_enabled' => $website->getGoogleLinkEnabled(),
    			'linkedin_link_enabled' => $website->getLinkedinLinkEnabled(),
    			'instagram_link_enabled' => $website->getInstagramLinkEnabled(),
    			'show_about_tab' => $website->getShowAboutTab(),
    			'show_services_tab' => $website->getShowServicesTab(),
    			'show_reviews_tab' => $website->getShowReviewsTab(),
    			'show_gallery_tab' => $website->getShowGalleryTab(),
    			'show_contact_tab' => $website->getShowContactTab(),
    			'show_subscription' => $website->getShowSubscription(),
    			'postcode' => $website->getPostcode(),
    			'subscribe_title' => $website->getSubscribeTitle(),
    			'subscribe_subtitle' => $website->getSubscribeSubtitle(),
    			'copyright' => $website->getCopyright(),
    			'company_name' => $website->getCompanyName(),
    			'show_logo' => $website->getShowLogo(),
    			'logo_url' => (is_null($website->getLogoPath())) ? null : $path_logo.$website->getLogoPath(),
    			'btn_txt_raq' => $website->getBtnTxtRaq(),
    			'btn_txt_gaq' => $website->getBtnTxtGaq(),
    			'btn_txt_war' => $website->getBtnTxtWar(),
    			'zoom_maps' => $website->getZoomMaps(),
    			'facebook_timeline_script' => $website->getFacebookTimelineScript(),
    			'facebook_show_timeline' => $website->getFacebookShowTimeline(),
    			'twitter_timeline_script' => $website->getTwitterTimelineScript(),
    			'twitter_show_timeline' => $website->getTwitterShowTimeline(),
    			'call_button' => $website->getCallButton(),
    			'footer_row1_type' => $website->getFooterRow1Type(),
    			'footer_row2_type' => $website->getFooterRow2Type(),
    			'footer_row3_type' => $website->getFooterRow3Type(),
    			'header_type' => $website->getHeaderType()
    	];

    	$em = $this->getDoctrine()->getManager();
    	$facebook = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_FB]);
    	$twitter = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_TWITTER]);
    	$favicon = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_FAVICON]);
    	if(is_object($facebook))$response['facebook_imge'] =( is_null($facebook->getPath())) ? null : $path.$facebook->getWebPath();
    	if(is_object($twitter))$response['twitter_imge'] = ( is_null($twitter->getPath())) ? null : $path.$twitter->getWebPath();
    	if(is_object($favicon))$response['favicon'] = ( is_null($favicon->getPath())) ? null : $path.$favicon->getWebPath();
    	else $response['favicon'] = $path."favicon.png";
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
             if(isset($params['twitter_page'])){
               $website->setTwitterPage($params['twitter_page']);
             }
             if(isset($params['instagram_link'])){
               $website->setInstagramLink($params['instagram_link']);
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
             if(isset($params['instagram_link_enabled'])){
               $website->setInstagramLinkEnabled($params['instagram_link_enabled']);
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

             if(isset($params['show_about_tab'])){
               $website->setShowAboutTab($params['show_about_tab']);
             }
             if(isset($params['show_services_tab'])){
               $website->setShowServicesTab($params['show_services_tab']);
             }
             if(isset($params['show_gallery_tab'])){
               $website->setShowGalleryTab($params['show_gallery_tab']);
             }
             if(isset($params['show_reviews_tab'])){
               $website->setShowReviewsTab($params['show_reviews_tab']);
             }
             if(isset($params['show_contact_tab'])){
               $website->setShowContactTab($params['show_contact_tab']);
             }
             if(isset($params['show_subscription'])){
               $website->setShowSubscription($params['show_subscription']);
             }
             if(isset($params['zoom_maps'])){
               $website->setZoomMaps($params['zoom_maps']);
             }
             if(isset($params['facebook_timeline_script'])){
               $website->setFacebookTimelineScript($params['facebook_timeline_script']);
             }
             if(isset($params['facebook_show_timeline'])){
               $website->setFacebookShowTimeline($params['facebook_show_timeline']);
             }
             if(isset($params['twitter_timeline_script'])){
               $website->setTwitterTimelineScript($params['twitter_timeline_script']);
             }
             if(isset($params['twitter_show_timeline'])){
               $website->setTwitterShowTimeline($params['twitter_show_timeline']);
             }
             if(isset($params['call_button'])){
               $website->setCallButton($params['call_button']);
             }
             if(isset($params['footer_row1_type'])){
               $website->setFooterRow1Type($params['footer_row1_type']);
             }
             if(isset($params['footer_row2_type'])){
               $website->setFooterRow2Type($params['footer_row2_type']);
             }
             if(isset($params['footer_row3_type'])){
               $website->setFooterRow3Type($params['footer_row3_type']);
             }
             if(isset($params['header_type'])){
               $website->setHeaderType($params['header_type']);
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



    /**
     * @Route("/api/v1/website/item", name="post_website_item")
     * @Method({"POST"})
     */
    public function postItemImageAction(Request $request)
    {

    	if( 	isset(Item::$STORECONFIG[ strtolower($request->request->get('type')) ]) &&
    			isset(Item::$STORECONFIG[ strtolower($request->request->get('type')) ]['access'] ) &&
    			Item::$STORECONFIG[ strtolower($request->request->get('type')) ]['access'] == 'admin' )
    	{
    				$this->checkAdminAccess($request);
    	}
    	else
    	{
    		$this->checkAccess($request);
    	}

    	try{
	    	$em = $this->getDoctrine()->getManager();
	    	$file = $request->files->get('file');
	    	if(!is_null($file)) {
	    		$item = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(array('storage' => $request->request->get('type')));
	    		if( !is_object($item) ) $item = new Item($request->request->get('type'));
	    		$item->setFile($file);
	    		$item->upload();
	    		$em->persist($item);
	    		$em->flush();


	    		$path_social = 'http://'.$request->server->get('HTTP_HOST').'/';
	    		if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
	    			$path_social = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
	    		}

	    		$response = new Response(json_encode(
	    				[
	    						'code' => 200,
	    						'id' => $item->getId(),
	    						'url' => $path_social.$item->getWebPath()
	    				]));


	    	}else{

	    		$response = new Response(json_encode(
	    				[
	    						'code' => 1,
	    						'message' => 'Invalid Form'
	    				]));
	    	}
    	} catch (\Exception $e){
    		$response = new Response(json_encode(
    				[
    						'code' => 2,
    						'message' => $e->getMessage()
    				]));
    	}

    	$response->headers->set('Content-Type', 'application/json');
    	return $response;

    }

    /**
     * @Route("/api/v1/gallery_items/{id}", name="delete_website_item")
     * @Method({"DELETE"})
     */
    public function deleteItemAction(Request $request, $id)
    {
    	$this->checkAccess($request);

    	$em = $this->getDoctrine()->getManager();
    	$item =  $em->getRepository('AppBundle\Entity\Item\Item')->find($id);

    	if(is_object($item)){

    		$item->deleteFile();
    		$em->remove($item);
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
