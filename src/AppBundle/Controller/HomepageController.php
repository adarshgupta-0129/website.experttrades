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
        $reviews =  $em->getRepository('AppBundle\Entity\Review\Item\Item')->findBy([],['created' => 'DESC'], 3, 0);
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

                $data_string = json_encode([
                  'name' => $message->getName(),
                  'email' => $message->getEmail(),
                  'message' => $message->getMessage()
                ]);

                $ch = curl_init($this->container->getParameter('api_url').'trades/'.$website->getTradeId().'/website_notifications?website_access_token='.$website->getAccessToken());
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );

                $result = json_decode(curl_exec($ch));

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
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
          'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView()
        ));
    }
}
