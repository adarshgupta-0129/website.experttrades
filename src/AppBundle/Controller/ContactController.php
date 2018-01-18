<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

use AppBundle\Entity\QuoteRequest\QuoteRequest;
use AppBundle\Entity\QuoteRequest\JobCategory\JobCategory as QuoteRequestCategory;
use AppBundle\Entity\JobCategory\JobCategory;
use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class ContactController extends MainController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $error = "";

        $this->trackVisit();

        $array_twig = $this->defaultInfo($request);
        $array_twig['margin_top_subscription'] = false;

        $choices = [];
        foreach($em->getRepository('AppBundle\Entity\JobCategory\JobCategory')->findBy(array('deleted_at' => null)) as $c){
            $choices[$c->getName()] = $c->getName();
        }
        $date = new \Datetime();
        $quoteRequest = new QuoteRequest();
        if(!is_null($request->get('subject'))){
        	$quoteRequest->setJobDescription($request->get('subject').PHP_EOL.PHP_EOL);
        }
        $form = $this->createFormBuilder($quoteRequest)
            ->add('name', 'text', array('required' => true, 'constraints' => array(new NotBlank())))
            ->add('email', 'email', array('required' => false))
            ->add('phone', 'text', array('required' => true, 'constraints' => array(new NotBlank())))
            ->add('job_location', 'text')
            ->add('job_date', 'text', array('mapped' => false, 'data' => $date->format('d/m/Y')))
            ->add('job_description', 'textarea')
            ->add('job_categories', 'choice', [
                'choices' => $choices,
                'multiple' => true,
                'expanded' => true,
                'mapped' => false
            ])->add('submit', 'submit')
            ->getForm();

        $config = ['site_key' => '6LfVOBUTAAAAANuA1WqMKBYBbS7dC8DwbgINIWnn', 'site_secret' => '6LfVOBUTAAAAAM-wdIS07CEZ5bhgZzvrpa1s60Wl'];
        $recaptchaToken = new \ReCaptchaSecureToken\ReCaptchaToken($config);
        $sessionId = uniqid('recaptcha');
        $secureToken = $recaptchaToken->secureToken($sessionId);

        $form->handleRequest($request);
        if($request->isMethod('POST')){
        	try
        	{

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
	        	/*$result = [];
	        	$result['success'] = true;*/
	            
	            if(isset($result['success']) && $result['success']){
	
	                if ($form->isValid()) {
	
	                    $quoteRequest->setJobDate(\DateTime::createFromFormat('d/m/Y',$form->get('job_date')->getData()));
	                    $em->persist($quoteRequest);
	                    $em->flush();
	
	                    $categories = [];
	                    foreach($form->get('job_categories')->getData() as $c){
	
	                        $jobCategory = $em->getRepository('AppBundle\Entity\JobCategory\JobCategory')->findOneBy(array('name' => $c));
	                        if(is_object($jobCategory)) {
	
	                            $categories[] = $jobCategory->getName();
	
	
	                            $category = new QuoteRequestCategory();
	                            $category->setQuoteRequest($quoteRequest);
	                            $category->setJobCategory($jobCategory);
	                            $em->persist($category);
	                            $em->flush();
	                        }
	                    }
	
	                    $data_string = json_encode([
	                      'name' => $quoteRequest->getName(),
	                      'email' => $quoteRequest->getEmail(),
	                      'phone' => $quoteRequest->getPhone(),
	                      'job_description' => $quoteRequest->getJobDescription(),
	                      'job_date' => (is_object($quoteRequest->getJobDate())) ? $quoteRequest->getJobDate()->getTimestamp() : '',
	                      'job_location' => $quoteRequest->getJobLocation(),
	                      'categories' => $categories,
	                      'from' => 'website_contact'
	                    ]);
	
	                    $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
	                    $ch = curl_init($this->container->getParameter('api_url').'trades/'.$website->getTradeId().'/website_quote_requests?website_access_token='.$website->getAccessToken());
	                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	                        'Content-Type: application/json',
	                        'Content-Length: ' . strlen($data_string))
	                    );
	
	
	                    $result = json_decode(curl_exec($ch), true);
	                    
	                    if( $result['code'] != 200 ){
	                    	$error = 'We can not send your quote request. Please contact using phone number or try again later.';
	                    } else
	                    	return $this->redirect($this->generateUrl('contact').'?sent=true');
	
	                }else{
	                  $error = 'Please fill the mandatory fields. (name, email and phone)';
	                }
	
	            }else{
	              $error = 'Please click on the "I am not a Robot" checkbox';
	            }
        	} catch( \Exception $e ) {
        		$error = 'We can not send your quote request. Please contact using phone number or try again later.';
        	}
        }

        $array_twig['id_page'] = 'contact_page';
        $array_twig['error'] = $error;
        $array_twig['secureToken'] = $secureToken;
        $array_twig['form'] = $form->createView();
        return $this->render('AppBundle:contact:index.html.twig',$array_twig);
        /*array(
          'error' => $error,
          'secureToken' => $secureToken,
          'website' => $website,
        		'favicon' => $favicon,
        		'facebook_image' => $facebook_image,
        		'twitter_image' => $twitter_image,
           'hasBlog' => $blog->getActive(),
          'contact' => $contact,
          'footer_images' => $footerImages,
          'form' => $form->createView(),
          'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));*/
    }

    /**
     * @Route("/subscribe", name="subscribe")
     */
    public function subscribeAction(Request $request)
    {
        $subscriber = new Subscriber();
        $subscriberForm = $this->createFormBuilder($subscriber)
            ->add('email', 'text')
            ->getForm();

        $subscriberForm->handleRequest($request);
        if($request->isMethod('POST')){

            if ($subscriberForm->isValid()) {
                $em->persist($subscriber);
                $em->flush();

                $data_string = json_encode([
                  'email' => $subscriber->getEmail()
                ]);

                $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
                $ch = curl_init($this->container->getParameter('api_url').'trade/'.$website->getTradeId().'/website_subscriber?website_access_token='.$website->getAccessToken());
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );
            }
        }

        return $this->redirect($this->generateUrl('subscribe_success'));
    }
}
