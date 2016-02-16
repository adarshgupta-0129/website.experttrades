<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\JobCategory\JobCategory;

class JobCategoryController extends SecurityController
{
    /**
     * @Route("/api/v1/job_categories", name="get_job_categories")
     * @Method({"GET"})
     */
    public function getCategoriesAction(Request $request)
    {
        $this->checkAccess($request);
        $em = $this->getDoctrine()->getManager();

        $limit = $request->query->get('limit');
        $limit = (is_null($limit)) ? 10 : $limit;

        $offset = $request->query->get('offset');
        $offset = (is_null($offset)) ? 0 : $offset;

        $jobCategories = $em->getRepository('AppBundle\Entity\JobCategory\JobCategory')->getPaginated($limit, $offset);
        $response = new Response(json_encode($jobCategories));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/job_categories/{id}", name="get_job_category")
     * @Method({"GET"})
     */
    public function getCategoryAction(Request $request, $id)
    {
        $this->checkAccess($request);
        $em = $this->getDoctrine()->getManager();

        $jobCategories = $em->getRepository('AppBundle\Entity\JobCategory\JobCategory')->find($id);
        $response = new Response(json_encode([
          'id' => $jobCategories->getId(),
          'name' => $jobCategories->getName(),
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/job_categories/{id}", name="put_job_category")
     * @Method({"PUT"})
     */
    public function putCategoryAction(Request $request, $id)
    {
        $this->checkAccess($request);
        $em = $this->getDoctrine()->getManager();

        $jobCategory = $em->getRepository('AppBundle\Entity\JobCategory\JobCategory')->find($id);

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array

            if(isset($params['name'])){
              $jobCategory->setName($params['name']);
            }
            $em->persist($jobCategory);
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
     * @Route("/api/v1/job_categories", name="post_job_category")
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

             $jobCategory = new JobCategory();
             if(isset($params['name'])){
               $jobCategory->setName($params['name']);
             }
             $em->persist($jobCategory);
             $em->flush();

             $response = new Response(json_encode(
             [
               'id' => $jobCategory->getId()
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
     * @Route("/api/v1/job_categories/{id}", name="delete_job_category")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $category =  $em->getRepository('AppBundle\Entity\JobCategory\JobCategory')->find($id);

        if(is_object($category)){

            $category->setDeletedAt(new \DateTime("now",new \DateTimeZone('Europe/London')));
            $em->persist($category);
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
