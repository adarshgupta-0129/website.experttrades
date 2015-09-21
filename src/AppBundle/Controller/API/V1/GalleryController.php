<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Gallery\Item\Item;

class GalleryController extends SecurityController
{
    /**
     * @Route("/api/v1/gallery", name="get_gallery")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $gallery =  $em->getRepository('AppBundle\Entity\Gallery\Gallery')->find(1);

        $response = new Response(json_encode(
        [
          'header_text' => $gallery->getHeaderText(),
          'header_title' => $gallery->getHeaderTitle(),
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/gallery", name="post_gallery")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
         $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();
         $gallery =  $em->getRepository('AppBundle\Entity\Gallery\Gallery')->find(1);

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['header_text'])){
               $gallery->setHeaderText($params['header_text']);
             }
             if(isset($params['header_title'])){
               $gallery->setHeaderTitle($params['header_title']);
             }

             $em->persist($gallery);
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
     * @Route("/api/v1/gallery_items", name="get_gallery_items", requirements={"offset" = "\d+", "limit" = "\d+"}, defaults={"offset" = 0, "limit" = 10})
     * @Method({"GET"})
     */
    public function getItemsAction(Request $request)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();

      $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/images/gallery/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/gallery/';
      }

      $limit = $request->query->get('limit');
      $limit = (is_null($limit)) ? 10 : $limit;

      $offset = $request->query->get('offset');
      $offset = (is_null($offset)) ? 0 : $offset;

      $images =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')
      ->getPaginated($limit, $offset, $slidersPath);

      $response = new Response(json_encode($images));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/gallery_items/{id}", name="get_gallery_item")
     * @Method({"GET"})
     */
    public function getItemAction(Request $request, $id)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $image =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->find($id);

      $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/images/gallery/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/gallery/';
      }

      $response = new Response(json_encode([
        'id' => $image->getId(),
        'title' => $image->getTitle(),
        'image_url' => (is_null($image->getPath())) ? null : $slidersPath.$image->getPath()
      ]));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/gallery_items", name="post_gallery_item")
     * @Method({"POST"})
     */
    public function postItemAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
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
     * @Route("/api/v1/gallery_items/{id}", name="put_gallery_item")
     * @Method({"PUT"})
     */
    public function putItemAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->find($id);

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array

            if(isset($params['title'])){
                $item->setTitle($params['title']);
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
     * @Route("/api/v1/gallery_item_images", name="post_gallery_item_image")
     * @Method({"POST"})
     */
    public function postItemImageAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $file = $request->files->get('file');
        if(!is_null($file)) {
          
          $item = new Item();
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
     * @Route("/api/v1/gallery_items/{id}", name="delete_gallery_item")
     * @Method({"DELETE"})
     */
    public function deleteItemAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->find($id);

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
