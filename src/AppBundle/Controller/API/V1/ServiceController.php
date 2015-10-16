<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Service\Item\Item;

class ServiceController extends SecurityController
{
    /**
     * @Route("/api/v1/service", name="get_service")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);

        $response = new Response(json_encode(
        [
          'header_text' => $service->getHeaderText(),
          'header_title' => $service->getHeaderTitle(),
          'meta_title' => $service->getMetaTitle(),
          'meta_description' => $service->getMetaDescription()
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/service", name="post_service")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
         $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();
         $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['header_text'])){
               $service->setHeaderText($params['header_text']);
             }
             if(isset($params['header_title'])){
               $service->setHeaderTitle($params['header_title']);
             }

             if(isset($params['meta_title'])){
               $service->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $service->setMetaDescription($params['meta_description']);
             }

             $em->persist($service);
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

    /**
     * @Route("/api/v1/service_items", name="get_service_items", requirements={"offset" = "\d+", "limit" = "\d+"}, defaults={"offset" = 0, "limit" = 10})
     * @Method({"GET"})
     */
    public function getItemsAction(Request $request)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();

      $path = 'http://'.$request->server->get('HTTP_HOST').'/images/services/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/services/';
      }

      $limit = $request->query->get('limit');
      $limit = (is_null($limit)) ? 10 : $limit;

      $offset = $request->query->get('offset');
      $offset = (is_null($offset)) ? 0 : $offset;

      $images =  $em->getRepository('AppBundle\Entity\Service\Item\Item')
      ->getPaginated($limit, $offset, $path);

      $response = new Response(json_encode($images));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/service_items/{id}", name="get_service_item")
     * @Method({"GET"})
     */
    public function getItemAction(Request $request, $id)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $image =  $em->getRepository('AppBundle\Entity\Service\Item\Item')->find($id);

      $path = 'http://'.$request->server->get('HTTP_HOST').'/images/services/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/services/';
      }

      $response = new Response(json_encode([
        'id' => $image->getId(),
        'title' => $image->getTitle(),
        'subtitle' => $image->getSubtitle(),
       'image_url' => (is_null($image->getPath())) ? null : $path.$image->getPath()
      ]));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/service_items", name="post_service_item")
     * @Method({"POST"})
     */
    public function postItemAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();

        $item = new Item();
        $em->persist($item);
        $em->flush();

        $response = new Response(json_encode(
        [
          'id' => $item->getId(),
        ]));

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/api/v1/service_items/{id}", name="put_service_item")
     * @Method({"PUT"})
     */
    public function putItemAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Service\Item\Item')->find($id);

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array

            if(isset($params['title'])){
                $item->setTitle($params['title']);
            }
            if(isset($params['subtitle'])){
                $item->setSubtitle($params['subtitle']);
            }

            $em->persist($item);
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

    /**
     * @Route("/api/v1/service_item_image/{id}", name="post_service_item_image")
     * @Method({"POST"})
     */
    public function postItemImageAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Service\Item\Item')->find($id);

        $file = $request->files->get('file');
        if(!is_null($file)) {

          $item->setFile($file);
          $item->upload();
          $em->persist($item);
          $em->flush();

          $response = new Response(json_encode(
          [
            'code' => 200,
            'message' => 'OK'
          ]));

          $response->headers->set('Content-Type', 'application/json');
          return $response;

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

    /**
     * @Route("/api/v1/service_items/{id}", name="delete_service_item")
     * @Method({"DELETE"})
     */
    public function deleteItemAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Service\Item\Item')->find($id);

        if(is_object($item)){

            $item->deleteFile();
            $em->remove($item);
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
