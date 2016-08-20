<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Message\Message;

use AppBundle\Entity\Item\Item;

class HomepageController extends MainController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $contact =  $em->getRepository('AppBundle\Entity\Contact\Contact')->find(1);
        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);
        $aboutUs =  $em->getRepository('AppBundle\Entity\AboutUs\AboutUs')->find(1);
        $reviews =  $em->getRepository('AppBundle\Entity\Review\Item\Item')->findBy([],['created' => 'DESC'], 3, 0);
        $services =  $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy([],['order' => 'ASC','id' => 'DESC'], 3, 0);
        $total_landscape = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->total_landscape();
        $total_portrait =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->total_portrait();
        $facebook = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_FB]);
    	$twitter = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_TWITTER]);
    	$favicon = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_FAVICON]);
      $facebook_image = null;
      $twitter_image = null;
    	if(is_object($facebook))$facebook_image =( is_null($facebook->getPath())) ? null : $facebook->getWebPath();
    	if(is_object($twitter))$twitter_image = ( is_null($twitter->getPath())) ? null : $twitter->getWebPath();
    	if(is_object($favicon))$favicon = ( is_null($favicon->getPath())) ? null : $favicon->getWebPath();
        //var_dump($total_portrait.'::'.$total_landscape);die();
        if(	$total_portrait  == 0 ){
        	$perPage = 8;
        	$landscape = true;
        	$portrait = false;
        }
        elseif ( $total_landscape == 0 )
        {
        	$perPage = 4;
        	$landscape = false;
        	$portrait = true;
        }
        else
        {
        	$perPage = 8;
        	$landscape = false;
        	$portrait = false;
        }
        $images =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], $perPage, 0);
        $pos_items= [];
        if(!$landscape && !$portrait ) {
        	$portraidc = 0;
        	$landscapec = 0;
        	$count = 0;
        	foreach ($images as $key => $value ){
        		if($value->getWidth() >= $value->getHeight() || ($value->getWidth() == 0 && $value->getHeight() == 0)){
        			$landscapec++;
        			$pos_items[$key] = 'landscape';
        		} else {
        			$portraidc++;
        			$pos_items[$key] = 'portrait';
        		}
        		$count++;
        	}
        }

        $findMeOns =  $em->getRepository('AppBundle\Entity\Homepage\FindMeOn\Item\Item')->findAll();
        $footerImages = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        $contactError = "";
        $config = ['site_key' => '6LfVOBUTAAAAANuA1WqMKBYBbS7dC8DwbgINIWnn', 'site_secret' => '6LfVOBUTAAAAAM-wdIS07CEZ5bhgZzvrpa1s60Wl'];
        $recaptchaToken = new \ReCaptchaSecureToken\ReCaptchaToken($config);
        $sessionId = uniqid('recaptcha');
        $secureToken = $recaptchaToken->secureToken($sessionId);

        $message = new Message();
        $contactForm = $this->createFormBuilder($message)
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('phone', 'text')
            ->add('message', 'textarea')
            ->getForm();

        $contactForm->handleRequest($request);
        if($this->getRequest()->isMethod('POST')){

            if ($contactForm->isValid()) {

              //open connection
                $ch = curl_init();
                //set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query([
                  'secret' => '6LfVOBUTAAAAAM-wdIS07CEZ5bhgZzvrpa1s60Wl',
                  'response' => $this->get('request')->request->get('g-recaptcha-response'),
                  'remoteip' => $this->container->get('request')->getClientIp()
                ]));

                //execute post
                $result = json_decode(curl_exec($ch), true);
                //close connection
                curl_close($ch);

                //if(isset($result['success']) && $result['success']){

                    $em->persist($message);
                    $em->flush();

                    $data_string = json_encode([
                      'name' => $message->getName(),
                      'email' => $message->getEmail(),
                      'phone' => $message->getPhone(),
                      'message' => $message->getMessage(),
                      'from' => 'website'
                    ]);

                    $ch = curl_init($this->container->getParameter('api_url').'trades/'.$website->getTradeId().'/website_notifications?website_access_token='.$website->getAccessToken());
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string))
                    );

                    $result = json_decode(curl_exec($ch), true);
                    if( $result['code'] != 200 ){
                    	$contactError = 'We can not send your request. Please contact using phone number or try again.';
                    } else
                   		return $this->redirect($this->generateUrl('message_success'));

               /* }else{
                    $contactError = 'Please click on the "I am not a Robot" checkbox';
                }*/
            }
        }

        return $this->render('AppBundle:homepage:index.html.twig',
        array(
          'website' => $website,
           'hasBlog' => $blog->getActive(),
          'contact' => $contact,
          'homepage' => $homepage,
          'aboutUs' => $aboutUs,
          'reviews' => $reviews,
          'services' => $services,
          'images' => $images,
           'pos_items' => $pos_items,
           'portrait' => $portrait,
           'landscape' => $landscape,
           'favicon' => $favicon,
           'facebook_image' => $facebook_image,
           'twitter_image' => $twitter_image,
          'findMeOns' => $findMeOns,
          'footer_images' => $footerImages,
          'contactError' => $contactError,
          'secureToken' => $secureToken,
          'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
          'contact_form' => $contactForm->createView(),
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }
}
