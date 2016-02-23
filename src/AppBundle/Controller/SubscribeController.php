<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Subscriber\Subscriber;

class SubscribeController extends MainController
{
    /**
     * @Route("/subscribe", name="subscribe")
     * @Method({"POST"})
     */
    public function subscribeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);

        $subscriber = new Subscriber();
        $subscriberForm = $this->createFormBuilder($subscriber)
            ->add('email', 'email')
            ->getForm();

        $subscriberForm->handleRequest($request);
        if($this->getRequest()->isMethod('POST')){

            if ($subscriberForm->isValid()
             && filter_var($subscriber->getEmail(), FILTER_VALIDATE_EMAIL)) {
                $em->persist($subscriber);
                $em->flush();

                $data_string = json_encode([
                  'email' => $subscriber->getEmail()
                ]);

                $ch = curl_init($this->container->getParameter('api_url').'trades/'.$website->getTradeId().'/website_subscribers?website_access_token='.$website->getAccessToken());
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );

                $result = json_decode(curl_exec($ch));

                return $this->redirect($this->generateUrl('subscribe_success'));

            }
        }

        return $this->redirect($this->generateUrl('subscribe_error'));


    }

    /**
     * @Route("/subscribe-success", name="subscribe_success")
     */
    public function subscribeSuccessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);

        return $this->render('AppBundle:subscribe:success.html.twig',
         array(
           'website' => $website,
           'footer_images' => $footerImages,
           'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
         ));
      }


      /**
       * @Route("/subscribe-error", name="subscribe_error")
       */
      public function subscribeErrorAction(Request $request)
      {
          $em = $this->getDoctrine()->getManager();
          $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
          $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);

          return $this->render('AppBundle:subscribe:error.html.twig',
           array(
             'website' => $website,
             'footer_images' => $footerImages,
             'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
           ));
        }
}
