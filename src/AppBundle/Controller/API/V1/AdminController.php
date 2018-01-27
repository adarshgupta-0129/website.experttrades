<?php


namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Item\Item;

class AdminController extends SecurityController
{
    
    
    /**
     * @Route("/api/v1/admin/website", name="get_admin_website")
     * @Method({"GET"})
     */
    public function getAdminAction(Request $request)
    {
        $this->checkAdminAccess($request);
        $em = $this->getDoctrine()->getManager();
        $website = $em->getRepository('AppBundle\Entity\Website')->find(1);
        $array_response = $this->getWebsite($request, $website);
        $array_response['et_atw'] = $website->getAccessToken();
        $array_response['main_color'] = $website->getMainColor();
        $array_response['dark_color'] = $website->getDarkColor();
        $array_response['light_color'] = $website->getLightColor();
        $array_response['trade_id'] = $website->getTradeId();
        $array_response['trade_url'] = $website->getTradeUrl();
        $response = new Response(json_encode($array_response));
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
     * @Route("/api/v1/admin/website/clear_integration", name="post_admin_website_clear_integration")
     * @Method({"POST"})
     */
    public function postAdminClearIntegrationAction(Request $request)
    {
        $this->checkAdminAccess($request);
        $file_json =  __DIR__.'/../../../../../clear_integration.json';
        $file_json2 =  __DIR__.'/../../../../../launch_site.json';
        
        
        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
            $do_it = false;
            if( file_exists ( $file_json ) && !isset($params['force']) ){
                
                $response = new Response(json_encode(
                    [
                        'code' => 2,
                        'message' => "This color it's been used. We can not clear integration."
                    ]));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
            if( file_exists ( $file_json2 ) && !isset($params['force']) ){
                
                $response = new Response(json_encode(
                    [
                        'code' => 2,
                        'message' => "This color it's set up to launch, if you force the clear integration before the launch you may lost all the information."
                    ]));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
            
            if(isset($params['color'])){
                $color = $params['color'];
                if(isset($params['domain']))
                {
                    $domain = $params['domain'];
                    $domain = preg_replace('/^http(s)?:\/\//', '', $domain);
                    $domain = preg_replace('/^www\./', '', $domain);
                    $domain = trim($domain, '/');
                    //var_dump('domain: '.$domain);
                    $do_it = true;
                }
            }
            /**/
            if($do_it)
            {
                
                /**
                 if(true){
                 $color = 'white';
                 $domain = 'testwebsite.com';
                 /**/
                $command = escapeshellcmd('sudo -u www-data python /var/www/SCRIPTS/PHP_clear_integration_site.py -c '. $color .' -d '. $domain);
                $output = shell_exec($command);
                $array_response=[];
                $array_response['output_script'] = $output;
                if( strpos($output, 'ERROR:') !== FALSE ){
                    $array_response['error'] = true;
                }else {
                    $array_response['error'] = false;
                    
                    $array_json = [
                        'color' => $color,
                        'domain' => $domain,
                        'full_domain' => $params['domain'],
                        'data' => $array_response
                    ];
                    
                    if (!$handle = fopen($file_json, 'w')) {
                        $response = new Response(json_encode(
                            [
                                'code' => 1,
                                'message' => 'Something went wrong! Error creating json File!'
                            ]));
                    }
                    
                    // Write $somecontent to our opened file.
                    if (fwrite($handle, json_encode($array_json)) === FALSE) {
                        $response = new Response(json_encode(
                            [
                                'code' => 1,
                                'message' => 'Something went wrong! Error writing json File!'
                            ]));
                    }
                    
                    fclose($handle);
                    
                    
                }
                $response = new Response(json_encode($array_response));
            }
            else
            {
                $response = new Response(json_encode(
                    [
                        'code' => 1,
                        'message' => 'Invalid paramaters.'
                    ]));
            }
        }
        else
        {
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
     * @Route("/api/v1/admin/website/launch_site", name="post_admin_website_launch_site")
     * @Method({"POST"})
     */
    public function postAdminLaunchAction(Request $request)
    {
        $this->checkAdminAccess($request);
        $file_json =  __DIR__.'/../../../../../launch_site.json';
        
        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
            $do_it = false;
            if( file_exists ( $file_json ) && !isset($params['force']) ){
                
                $response = new Response(json_encode(
                    [
                        'code' => 2,
                        'message' => "This color it's already configurated for launch."
                    ]));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
            if(isset($params['color'])){
                $color = $params['color'];
                if(isset($params['domain']))
                {
                    $domain = $params['domain'];
                    $domain = preg_replace('/^http(s)?:\/\//', '', $domain);
                    $domain = preg_replace('/^www\./', '', $domain);
                    $domain = trim($domain, '/');
                    $do_it = true;
                }
            }
            
            if($do_it)
            {
                
                /**
                 if(true){
                 $color = 'white';
                 $domain = 'http://testwebsite.com';
                 /**/
                $array_json = [
                    'color' => $color,
                    'domain' => $domain,
                    'full_domain' => $params['domain']
                ];
                
                if (!$handle = fopen($file_json, 'w')) {
                    $response = new Response(json_encode(
                        [
                            'code' => 1,
                            'message' => 'Something went wrong! Error creating json File!'
                        ]));
                }
                
                // Write $somecontent to our opened file.
                if (fwrite($handle, json_encode($array_json)) === FALSE) {
                    $response = new Response(json_encode(
                        [
                            'code' => 1,
                            'message' => 'Something went wrong! Error writing json File!'
                        ]));
                }
                
                fclose($handle);
                $em = $this->getDoctrine()->getManager();
                $website = $em->getRepository('AppBundle\Entity\Website')->find(1);
                $array_response = $this->getWebsite($request, $website);
                $array_response['et_atw'] = $website->getAccessToken();
                $array_response['main_color'] = $website->getMainColor();
                $array_response['dark_color'] = $website->getDarkColor();
                $array_response['light_color'] = $website->getLightColor();
                $array_response['disabled'] = $website->getDisabled();
                $array_response['trade_id'] = $website->getTradeId();
                $array_response['trade_url'] = $website->getTradeUrl();
                $array_response['error'] = false;
                $response = new Response(json_encode($array_response));
                
            }
            else
            {
                $response = new Response(json_encode(
                    [
                        'code' => 1,
                        'message' => 'Invalid paramaters.'
                    ]));
            }
        }
        else
        {
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
     * @Route("/api/v1/admin/website", name="put_admin_website")
     * @Method({"PUT"})
     */
    public function putAdmintAction(Request $request)
    {
        $this->checkAdminAccess($request);
        
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        
        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
            
            
            if(isset($params['main_color'])){
                $website->setMainColor($params['main_color']);
            }
            if(isset($params['dark_color'])){
                $website->setDarkColor($params['dark_color']);
            }
            if(isset($params['light_color'])){
                $website->setLightColor($params['light_color']);
            }
            if(isset($params['trade_url'])){
                $website->setTradeUrl($params['trade_url']);
            }
            if(isset($params['trade_id'])){
                $website->setTradeId($params['trade_id']);
            }
            if(isset($params['disabled'])){
                if($params['disabled'] === true || $params['disabled'] === 1 || $params['disabled'] === 'true')
                    $website->setDisabled(true);
                    else
                        $website->setDisabled(false);
            }
            
            if(isset($params['btn_txt_raq'])){
                $website->setBtnTxtRaq($params['btn_txt_raq']);
            }
            if(isset($params['btn_txt_gaq'])){
                $website->setBtnTxtGaq($params['btn_txt_gaq']);
            }
            if(isset($params['btn_txt_war'])){
                $website->setBtnTxtWar($params['btn_txt_war']);
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
     * @Route("/api/v1/admin/website_headers", name="post_website_headers")
     * @Method({"POST"})
     */
    public function postHeadersAction(Request $request)
    {
        $this->checkAdminAccess($request);
        
        $em = $this->getDoctrine()->getManager();
        $file = $request->files->get('file');
        if(!is_null($file)) {
            
            $item = new Item(Item::STORE_HEADER);
            $item->setFile($file);
            $item->upload();
            
            $response = new Response(json_encode(
                [
                    'code' => 200,
                    'message' => ''
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
     * @Route("/api/v1/admin/website_extras", name="post_website_extras")
     * @Method({"POST"})
     */
    public function postExtrasAction(Request $request)
    {
        $this->checkAdminAccess($request);
        
        $em = $this->getDoctrine()->getManager();
        $file = $request->files->get('file');
        try{
            if(!is_null($file)) {
                
                $item = new Item(Item::STORE_EXTRAS);
                $item->setFile($file);
                $item->upload();
                
                $response = new Response(json_encode(
                    [
                        'code' => 200,
                        'message' => ''
                    ]));
                
                
            }else{
                
                $response = new Response(json_encode(
                    [
                        'code' => 1,
                        'message' => 'Invalid Form'
                    ]));
            }
        } catch(\Exception $e){
            
            $response = new Response(json_encode(
                [
                    'code' => 1,
                    'message' => 'Invalid Form :: '. $e->getMessage()
                ]));
        }
        
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    /**
     * @Route("/api/v1/admin/website_downloads", name="post_website_downloads")
     * @Method({"POST"})
     */
    public function postDownloadsAction(Request $request)
    {
        $this->checkAdminAccess($request);
        
        $em = $this->getDoctrine()->getManager();
        $file = $request->files->get('file');
        try{
            if(!is_null($file)) {
                
                $item = new Item(Item::STORE_DOCUMENTS_DOWNLOADS);
                $item->setFile($file);
                $item->upload();
                
                $response = new Response(json_encode(
                    [
                        'code' => 200,
                        'message' => ''
                    ]));
                
                
            }else{
                
                $response = new Response(json_encode(
                    [
                        'code' => 1,
                        'message' => 'Invalid Form'
                    ]));
            }
        } catch(\Exception $e){
            
            $response = new Response(json_encode(
                [
                    'code' => 1,
                    'message' => 'Invalid Form :: '. $e->getMessage()
                ]));
        }
        
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
