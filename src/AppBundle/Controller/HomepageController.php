<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Message\Message;

class HomepageController extends MainController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $contact =  $em->getRepository('AppBundle\Entity\Contact\Contact')->find(1);
        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);
        $aboutUs =  $em->getRepository('AppBundle\Entity\AboutUs\AboutUs')->find(1);
        $reviews =  $em->getRepository('AppBundle\Entity\Review\Item\Item')->findBy([],['created' => 'DESC'], 4, 0);
        $services =  $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy([],['id' => 'DESC'], 3, 0);
        $images =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 8, 0);
        $footerImages = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
        $this->trackVisit();

        $message = new Message();
        $contactForm = $this->createFormBuilder($message)
            ->add('name', 'text')
            ->add('email', 'text')
            ->add('message', 'textarea')
            ->getForm();

        $contactForm->handleRequest($request);
        if($this->getRequest()->isMethod('POST')){

            if ($contactForm->isValid()) {

                $em->persist($message);
                $em->flush();

                return $this->redirect($this->generateUrl('message_success'));
            }
        }

        return $this->render('AppBundle:homepage:index.html.twig',
        array(
          'website' => $website,
          'contact' => $contact,
          'homepage' => $homepage,
          'aboutUs' => $aboutUs,
          'reviews' => $reviews,
          'services' => $services,
          'images' => $images,
          'footer_images' => $footerImages,
          'contact_form' => $contactForm->createView(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }
}
