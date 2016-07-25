<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Service\Item\Item;
use AppBundle\Entity\Service\Item\File\File;

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
      ->getPaginatedAdmin($limit, $offset, $path);

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
      $item =  $em->getRepository('AppBundle\Entity\Service\Item\Item')->find($id);

      $path = 'http://'.$request->server->get('HTTP_HOST').'/images/services/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/services/';
      }

      $response = new Response(json_encode([
        'id' => $item->getId(),
        'title' => $item->getTitle(),
        'subtitle' => $item->getSubtitle(),
        'page_slug' => $item->getPageSlug(),
        'page_meta_title' => $item->getPageMetaTitle(),
        'page_meta_description' => $item->getPageMetaDescription(),
        'page_title' => $item->getPageTitle(),
        'page_html' => $item->getPageHtml(),
        'page_active' => $item->getPageActive(),
        'custom_header' => $item->getCustomHeader(),
        'image_url' => (is_null($item->getPath())) ? null : $path.$item->getPath(),
        'header_image_url' => (is_null($item->getPath())) ? null : $path.$item->getHeaderPath()
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
            if(isset($params['page_slug'])){
                $item->setPageSlug($params['page_slug']);
            }
            if(isset($params['page_meta_title'])){
                $item->setPageMetaTitle($params['page_meta_title']);
            }
            if(isset($params['page_meta_description'])){
                $item->setPageMetaDescription($params['page_meta_description']);
            }
            if(isset($params['page_active'])){
                $item->setPageActive($params['page_active']);
            }
            if(isset($params['custom_header'])){
                $item->setCustomHeader($params['custom_header']);
            }
            if(isset($params['page_title'])){
                $item->setPageTitle($params['page_title']);
            }
            if(isset($params['page_html'])){
                $item->setPageHtml($params['page_html']);
            }
            if(isset($params['page_active'])){
                $item->setPageActive($params['page_active']);
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
     * @Route("/api/v1/service_item_header_image/{id}", name="post_service_item_header_image")
     * @Method({"POST"})
     */
    public function postItemHeaderImageAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Service\Item\Item')->find($id);

        $file = $request->files->get('file');
        if(!is_null($file)) {

          $item->setHeaderFile($file);
          $item->uploadHeader();
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
            $item->deleteHeaderFile();
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

    /**
     * @Route("/api/v1/service_items/{id}/files", name="get_service_item_files")
     * @Method({"GET"})
     */
    public function getServiceItemFilesAction(Request $request, $id)
    {
      	$this->checkAccess($request);
      	$limit = $request->query->get('limit');
      	$limit = (is_null($limit) || !is_numeric($limit)) ? 25 : $limit;

      	$offset = $request->query->get('offset');
      	$offset = (is_null($offset) || !is_numeric($offset)) ? 0 : $offset;

        $type = $request->query->get('type');
        $type = (is_null($type)) ? 'img' : $type;

        $em = $this->getDoctrine()->getManager();

        $path = 'http://'.$request->server->get('HTTP_HOST').'/';
        if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
        	$path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
        }
        $return = $em->getRepository('AppBundle\Entity\Service\Item\File\File')
        ->getPaginated($id, $type, $limit, $offset, $path);

        $response = new Response(json_encode($return));

  	    $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * @Route("/api/v1/service_items/{serviceId}/files", name="post_service_item_files")
     * @Method({"POST"})
     */
    public function postServiceItemFileAction(Request $request, $serviceId)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $file = $request->files->get('file');
        $isValid = false;
        $type="";

        if(isset($_REQUEST['type']) && !is_null($file)){
        	if($_REQUEST['type'] == File::FILE_IMAGE && in_array($file->getMimeType(), File::$MIMETYPE[File::FILE_IMAGE])){
        		$isValid = true;
        		$type = File::FILE_IMAGE;
        	}else if($_REQUEST['type'] == File::FILE_PDF && in_array($file->getMimeType(), File::$MIMETYPE[File::FILE_PDF])){
        		$isValid = true;
        		$type = File::FILE_PDF;
        	}
        }

        if(!$isValid){
          $mime = (is_object($file)) ? $file->getMimeType() : "";
          $response = new Response(json_encode(
          [
            'error' => 1,
            'message' => 'The '.$mime.' format is invalid'
          ]));
          $response->headers->set('Content-Type', 'application/json');
          return $response;
        }

        $item = $em->getRepository('AppBundle\Entity\Service\Item\Item')->find($serviceId);

        $newFile = new File();
        $newFile->setItem($item);

        $title = $request->request->get('title');
        if(!is_null($title)){
          $newFile->setTitle($title);
        }else{

            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
                if(isset($params['title'])){
                    $newFile->setTitle($params['title']);
                }
            }
        }

        if($type != ""){
        	$newFile->setType($type);
        }
        $newFile->setFile($file);
        $newFile->upload();

        $em->persist($newFile);
        $em->flush();

        $path = 'http://'.$request->server->get('HTTP_HOST').'/';
        if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
        	$path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
        }
        $response = new Response(json_encode(
        [
          'id' => $newFile->getId(),
          'title' => $newFile->getTitle(),
          'url' => $path.$newFile->getWebPath(),
        ]));

        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * @Route("/api/v1/service_items/{serviceId}/files/{id}", name="delete_service_item_files")
     * @Method({"DELETE"})
     */
    public function deleteServiceItemFileAction(Request $request, $serviceId, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('AppBundle\Entity\Service\Item\File\File')->find($id);

        if(is_object($file)){

            $file->deleteFile();
            $em->remove($file);
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
