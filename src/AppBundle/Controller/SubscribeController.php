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

    /**
     * @Route("/subscribe-success", name="subscribe_success")
     */
    public function subscribeSuccessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);

        return $this->render('AppBundle:subscribe:success.html.twig', array('website' => $website, 'footer_images' => $footerImages));
    }
}
