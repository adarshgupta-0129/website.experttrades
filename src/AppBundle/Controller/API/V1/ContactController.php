<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Contact\Item\Item;

class ContactController extends SecurityController
{
    /**
     * @Route("/api/v1/contact", name="get_contact")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $contact =  $em->getRepository('AppBundle\Entity\Contact\Contact')->find(1);

        $response = new Response(json_encode(
        [
          'header_text' => $contact->getHeaderText(),
          'header_title' => $contact->getHeaderTitle(),
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/contact", name="post_contact")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
         $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();
         $contact =  $em->getRepository('AppBundle\Entity\Contact\Contact')->find(1);

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['header_text'])){
               $contact->setHeaderText($params['header_text']);
             }
             if(isset($params['header_title'])){
               $contact->setHeaderTitle($params['header_title']);
             }

             $em->persist($contact);
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
}
