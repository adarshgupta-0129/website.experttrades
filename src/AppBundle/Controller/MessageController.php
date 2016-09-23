<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Item\Item;

class MessageController extends MainController
{
    /**
     * @Route("/message-success", name="message_success")
     */
    public function messageSuccessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
    	$array_twig = $this->defaultInfo($request);
        

        return $this->render('AppBundle:message:success.html.twig', $array_twig);
    }
}
