<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Homepage\FindMeOn\Item\Item;

class FindMeOnController extends SecurityController
{
  /**
   * @Route("/api/v1/find_me_on_items", name="get_find_me_on_items", requirements={"offset" = "\d+", "limit" = "\d+"}, defaults={"offset" = 0, "limit" = 10})
   * @Method({"GET"})
   */
  public function getFindMeOnItemsAction(Request $request)
  {
    $this->checkAccess($request);

    $em = $this->getDoctrine()->getManager();

    $limit = $request->query->get('limit');
    $limit = (is_null($limit)) ? 10 : $limit;

    $offset = $request->query->get('offset');
    $offset = (is_null($offset)) ? 0 : $offset;

    $path = 'http://'.$request->server->get('HTTP_HOST').'/images/find_me_on/';
    if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
          $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/find_me_on/';
    }

    $items =  $em->getRepository('AppBundle\Entity\Homepage\FindMeOn\Item\Item')
    ->getPaginated($limit, $offset, $path);

    $response = new Response(json_encode($items));
    $response->headers->set('Content-Type', 'application/json');

    return $response;

  }

  /**
   * @Route("/api/v1/find_me_on_items/{id}", name="get_find_me_on_item")
   * @Method({"GET"})
   */
  public function getItemAction(Request $request, $id)
  {
    $this->checkAccess($request);

    $em = $this->getDoctrine()->getManager();
    $item =  $em->getRepository('AppBundle\Entity\Homepage\FindMeOn\Item\Item')->find($id);
    if(!is_object($item)){
        throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
    }

    $path = 'http://'.$request->server->get('HTTP_HOST').'/images/find_me_on/';
    if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
          $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/find_me_on/';
    }

    $response = new Response(json_encode([
      'id' => $item->getId(),
      'link' => $item->getLink(),
      'image_url' => (is_null($item->getPath())) ? null : $path.$item->getPath()
    ]));
    $response->headers->set('Content-Type', 'application/json');

    return $response;

  }

  /**
   * @Route("/api/v1/find_me_on_items", name="post_find_me_on_item")
   * @Method({"POST"})
   */
  public function postItemAction(Request $request)
  {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();

      $item = new Item();
      $em->persist($item);
      $em->flush();

      $file = $request->files->get('file');
      if(!is_null($file)) {

        $item->setFile($file);
        $item->upload();
        $em->persist($item);
        $em->flush();

        $response = new Response(json_encode(
        [
          'id' => $item->getId(),
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
   * @Route("/api/v1/find_me_on_items/{id}", name="put_find_me_on_item")
   * @Method({"PUT"})
   */
  public function putItemAction(Request $request, $id)
  {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $item =  $em->getRepository('AppBundle\Entity\Homepage\FindMeOn\Item\Item')->find($id);

      $params = array();
      $content = $this->get("request")->getContent();
      if (!empty($content))
      {
          $params = json_decode($content, true); // 2nd param to get as array

          if(isset($params['link'])){
              $item->setLink($params['link']);
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
   * @Route("/api/v1/find_me_on_items/{id}", name="delete_find_me_on_item")
   * @Method({"DELETE"})
   */
  public function deleteItemAction(Request $request, $id)
  {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $item =  $em->getRepository('AppBundle\Entity\Homepage\FindMeOn\Item\Item')->find($id);

      if(is_object($item)){

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
