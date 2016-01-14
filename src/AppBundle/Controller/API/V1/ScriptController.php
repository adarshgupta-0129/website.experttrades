<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Script\Script;

class ScriptController extends SecurityController
{
  /**
   * @Route("/api/v1/scripts", name="get_scripts", requirements={"offset" = "\d+", "limit" = "\d+"}, defaults={"offset" = 0, "limit" = 10})
   * @Method({"GET"})
   */
  public function getScriptsAction(Request $request)
  {
    $this->checkAccess($request);

    $em = $this->getDoctrine()->getManager();

    $limit = $request->query->get('limit');
    $limit = (is_null($limit)) ? 10 : $limit;

    $offset = $request->query->get('offset');
    $offset = (is_null($offset)) ? 0 : $offset;

    $scripts =  $em->getRepository('AppBundle\Entity\Script\Script')
    ->getPaginated($limit, $offset);

    $response = new Response(json_encode($scripts));
    $response->headers->set('Content-Type', 'application/json');

    return $response;

  }

  /**
   * @Route("/api/v1/scripts/{id}", name="get_script")
   * @Method({"GET"})
   */
  public function getScriptAction(Request $request, $id)
  {
    $this->checkAccess($request);

    $em = $this->getDoctrine()->getManager();
    $script =  $em->getRepository('AppBundle\Entity\Script\Script')->find($id);

    $response = new Response(json_encode([
      'id' => $script->getId(),
      'name' => $script->getName(),
      'value' => $script->getValue()
    ]));
    $response->headers->set('Content-Type', 'application/json');

    return $response;

  }

  /**
   * @Route("/api/v1/scripts", name="post_script")
   * @Method({"POST"})
   */
  public function postItemAction(Request $request)
  {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();

      $script = new Script();
      $em->persist($script);
      $em->flush();

      $response = new Response(json_encode(
      [
        'id' => $script->getId(),
      ]));

      $response->headers->set('Content-Type', 'application/json');
      return $response;
  }

  /**
   * @Route("/api/v1/scripts/{id}", name="put_script")
   * @Method({"PUT"})
   */
  public function putScriptAction(Request $request, $id)
  {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $script =  $em->getRepository('AppBundle\Entity\Script\Script')->find($id);

      $params = array();
      $content = $this->get("request")->getContent();
      if (!empty($content))
      {
          $params = json_decode($content, true); // 2nd param to get as array

          if(isset($params['name'])){
              $script->setName($params['name']);
          }
          if(isset($params['value'])){
              $script->setValue($params['value']);
          }

          $em->persist($script);
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
   * @Route("/api/v1/scripts/{id}", name="delete_script")
   * @Method({"DELETE"})
   */
  public function deleteScriptAction(Request $request, $id)
  {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $item =  $em->getRepository('AppBundle\Entity\Script\Script')->find($id);

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
