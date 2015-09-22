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
        foreach($em->getRepository('AppBundle\Entity\JobCategory\JobCategory')->findAll() as $c){
            $choices[$c->getName()] = $c->getName();
        }

        $quoteRequest = new QuoteRequest();
        $form = $this->createFormBuilder($quoteRequest)
            ->add('name', 'text')
            ->add('email', 'text')
            ->add('phone', 'text')
            ->add('job_location', 'text')
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

                $em->persist($quoteRequest);
                $em->flush();

                foreach($form->get('job_categories')->getData() as $c){

                    $jobCategory = $em->getRepository('AppBundle\Entity\JobCategory\JobCategory')->findOneBy(array('name' => $c));
                    if(is_object($jobCategory)) {

                        $category = new QuoteRequestCategory();
                        $category->setQuoteRequest($quoteRequest);
                        $category->setJobCategory($jobCategory);
                        $em->persist($category);
                        $em->flush();
                    }
                }

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
            }
        }

        return $this->redirect($this->generateUrl('subscribe_success'));
    }
}
