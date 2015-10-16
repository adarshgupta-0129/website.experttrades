<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\QuoteRequest\QuoteRequest;
use AppBundle\Entity\QuoteRequest\JobCategory\JobCategory as QuoteRequestCategory;
use AppBundle\Entity\JobCategory\JobCategory;
use AppBundle\Entity\Subscriber\Subscriber;

class ContactController extends MainController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $contact =  $em->getRepository('AppBundle\Entity\Contact\Contact')->find(1);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        $choices = [];
        foreach($em->getRepository('AppBundle\Entity\JobCategory\JobCategory')->findBy(array('deleted_at' => null)) as $c){
            $choices[$c->getName()] = $c->getName();
        }
        $date = new \Datetime();
        $quoteRequest = new QuoteRequest();
        $form = $this->createFormBuilder($quoteRequest)
            ->add('name', 'text')
            ->add('email', 'text')
            ->add('phone', 'text')
            ->add('job_location', 'text')
            ->add('job_date', 'text', array('mapped' => false, 'data' => $date->format('d/m/Y')))
            ->add('job_description', 'textarea')
            ->add('job_categories', 'choice', [
                'choices' => $choices,
                'multiple' => true,
                'expanded' => true,
                'mapped' => false
            ])
            ->getForm();

        $form->handleRequest($request);
        if($this->getRequest()->isMethod('POST')){

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
                  'job_date' => (is_object($quoteRequest->getJobDate())) ? $quoteRequest->getJobDate()->format('Y-m-d H:i') : '',
                  'job_location' => $quoteRequest->getJobLocation(),
                  'categories' => $categories
                ]);

                $ch = curl_init($this->container->getParameter('api_url').'trades/'.$website->getTradeId().'/website_quote_requests?website_access_token='.$website->getAccessToken());
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );

                $result = json_decode(curl_exec($ch));

                return $this->redirect($this->generateUrl('contact').'?sent=true');
            }
        }

        return $this->render('AppBundle:contact:index.html.twig',
        array(
          'website' => $website,
          'contact' => $contact,
          'footer_images' => $footerImages,
          'form' => $form->createView(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
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
        if($this->getRequest()->isMethod('POST')){

            if ($subscriberForm->isValid()) {
                $em->persist($subscriber);
                $em->flush();

                $data_string = json_encode([
                  'email' => $subscriber->getEmail()
                ]);

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
