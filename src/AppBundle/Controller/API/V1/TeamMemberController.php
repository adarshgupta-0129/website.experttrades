<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\TeamMember\TeamMember;

class TeamMemberController extends SecurityController
{
    /**
     * @Route("/api/v1/team_members", name="get_team_members")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();

        $limit = $request->query->get('limit');
        $limit = (is_null($limit)) ? 10 : $limit;

        $offset = $request->query->get('offset');
        $offset = (is_null($offset)) ? 0 : $offset;

        $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/images/team_members/';
        if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
              $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/team_members/';
        }

        $teamMembers =  $em->getRepository('AppBundle\Entity\TeamMember\TeamMember')
        ->getPaginated($limit, $offset, $slidersPath);

        $response = new Response(json_encode($teamMembers));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/team_members/{id}", name="get_team_member")
     * @Method({"GET"})
     */
    public function getTeamMemberAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();

        $teamMember = $em->getRepository('AppBundle\Entity\TeamMember\TeamMember')
        ->find($id);

        $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/images/team_members/';
        if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
              $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/team_members/';
        }

        $response = new Response(json_encode([
          'id' => $teamMember->getId(),
          'name' => $teamMember->getName(),
          'title' => $teamMember->getTitle(),
          'image_url' => (is_null($teamMember->getPath())) ? null : $slidersPath.$teamMember->getPath()
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/team_members/{id}", name="put_team_member")
     * @Method({"PUT"})
     */
    public function putAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\TeamMember\TeamMember')->find($id);

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array

            if(isset($params['title'])){
                $item->setTitle($params['title']);
            }
            if(isset($params['name'])){
                $item->setName($params['name']);
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
     * @Route("/api/v1/team_members", name="post_team_members")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
        $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             $teamMember = new TeamMember();
             if(isset($params['name'])){
               $teamMember->setName($params['name']);
             }
             if(isset($params['title'])){
               $teamMember->setTitle($params['title']);
             }

             $em->persist($teamMember);
             $em->flush();

             $response = new Response(json_encode(
             [
               'id' => $teamMember->getId()
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
     * @Route("/api/v1/team_member_image/{id}", name="post_team_member_image")
     * @Method({"POST"})
     */
    public function postItemImageAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\TeamMember\TeamMember')->find($id);

        $file = $request->files->get('file');
        if(!is_null($file)) {

          $item->deleteFile();

          $item->setFile($file);
          $item->upload();
          $em->persist($item);
          $em->flush();

          $response = new Response(json_encode(
          [
            'id' => $item->getId()
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
     * @Route("/api/v1/team_members/{id}", name="delete_team_member")
     * @Method({"DELETE"})
     */
    public function deleteTeamMemberAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\TeamMember\TeamMember')->find($id);

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
