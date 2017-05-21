<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Review\Item\Item;

class ReviewController extends SecurityController
{
    /**
     * @Route("/api/v1/review", name="get_review")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);

        $response = new Response(json_encode(
        [
          'header_text' => $review->getHeaderText(),
          'header_title' => $review->getHeaderTitle(),
          'header_subtitle' => $review->getHeaderSubtitle(),
          'meta_title' => $review->getMetaTitle(),
          'meta_description' => $review->getMetaDescription()
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/review", name="post_review")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
         $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();
         $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['header_text'])){
               $review->setHeaderText($params['header_text']);
             }
             if(isset($params['header_title'])){
               $review->setHeaderTitle($params['header_title']);
             }

             if(isset($params['header_subtitle'])){
               $review->setHeaderSubtitle($params['header_subtitle']);
             }

             if(isset($params['meta_title'])){
               $review->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $review->setMetaDescription($params['meta_description']);
             }

             $em->persist($review);
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
     * @Route("/api/v1/review_items", name="get_review_items", requirements={"offset" = "\d+", "limit" = "\d+"}, defaults={"offset" = 0, "limit" = 10})
     * @Method({"GET"})
     */
    public function getItemsAction(Request $request)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();

      $path = 'http://'.$request->server->get('HTTP_HOST').'/images/reviews/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/reviews/';
      }

      $limit = $request->query->get('limit');
      $limit = (is_null($limit)) ? 10 : $limit;

      $offset = $request->query->get('offset');
      $offset = (is_null($offset)) ? 0 : $offset;

      $images =  $em->getRepository('AppBundle\Entity\Review\Item\Item')
      ->getPaginated($limit, $offset, $path);

      $response = new Response(json_encode($images));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/review_items/{id}", name="get_review_item")
     * @Method({"GET"})
     */
    public function getItemAction(Request $request, $id)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $item =  $em->getRepository('AppBundle\Entity\Review\Item\Item')->find($id);

      $response = new Response(json_encode([
        'id' => $item->getId(),
        'expert_trades_review_id' => $item->getExpertTradesReviewId(),
        'title' => $item->getTitle(),
        'message' => $item->getMessage(),
        'job_description' => $item->getJobDescription(),
        'job_location' => $item->getJobLocation(),
        'job_done_date' => (is_object($item->getJobDoneDate()) && !is_null($item->getJobDoneDate())) ? $item->getJobDoneDate()->format('Y-m-d') : '',
        'rate_time_management' => $item->getRateTimeManagement(),
        'rate_friendly' => $item->getRateFriendly(),
        'rate_tidiness' => $item->getRateTidiness(),
        'rate_value' => $item->getRateValue(),
        'rate_total' => $item->getRateTotal(),
        'author_name' => $item->getAuthorName(),
        'ext_provider_name' => $item->getExtProviderName(),
        'ext_provider_url' => $item->getExtProviderUrl()

      ]));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/review_items", name="post_review_item")
     * @Method({"POST"})
     */
    public function postItemAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array

            $item = new Item();
            if(isset($params['expert_trades_review_id'])){
              $item->setExpertTradesReviewId($params['expert_trades_review_id']);
            }
            if(isset($params['title'])){
              $item->setTitle($params['title']);
            }
            if(isset($params['message'])){
              $item->setMessage($params['message']);
            }
            if(isset($params['ext_provider_name'])){
              $item->setExtProviderName($params['ext_provider_name']);
            }
            if(isset($params['ext_provider_url'])){
              $item->setExtProviderUrl($params['ext_provider_url']);
            }
            if(isset($params['author_name'])){
              $item->setAuthorName($params['author_name']);
            }
            if(isset($params['job_description'])){
              $item->setJobDescription($params['job_description']);
            }
            if(isset($params['job_location'])){
              $item->setJobLocation($params['job_location']);
            }
            if(isset($params['rate_time_management'])){
              $item->setRateTimeManagement($params['rate_time_management']);
            }
            if(isset($params['rate_friendly'])){
              $item->setRateFriendly($params['rate_friendly']);
            }
            if(isset($params['rate_tidiness'])){
              $item->setRateTidiness($params['rate_tidiness']);
            }
            if(isset($params['rate_value'])){
              $item->setRateValue($params['rate_value']);
            }
            if(isset($params['job_done_date'])){
              $item->setJobDoneDate(\DateTime::createFromFormat('Y-m-d', substr($params['job_done_date'], 0, 10)));
            }

            $rateTotal = round((($item->getRateTimeManagement() + $item->getRateFriendly() + $item->getRateTidiness() + $item->getRateValue()) / 4), 0, PHP_ROUND_HALF_UP);
            $item->setRateTotal($rateTotal);
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
     * @Route("/api/v1/review_items/{id}", name="put_review_items")
     * @Method({"PUT"})
     */
    public function putItemAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Review\Item\Item')->find($id);

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array

            if(isset($params['title'])){
              $item->setTitle($params['title']);
            }
            if(isset($params['message'])){
              $item->setMessage($params['message']);
            }
            if(isset($params['ext_provider_name'])){
              $item->setExtProviderName($params['ext_provider_name']);
            }
            if(isset($params['ext_provider_url'])){
              $item->setExtProviderUrl($params['ext_provider_url']);
            }
            if(isset($params['author_name'])){
              $item->setAuthorName($params['author_name']);
            }
            if(isset($params['job_description'])){
              $item->setJobDescription($params['job_description']);
            }
            if(isset($params['job_location'])){
              $item->setJobLocation($params['job_location']);
            }

            if(isset($params['job_done_date'])){
              $item->setJobDoneDate(\DateTime::createFromFormat('Y-m-d', substr($params['job_done_date'], 0, 10)));
            }
            if(isset($params['rate_time_management'])){
              $item->setRateTimeManagement($params['rate_time_management']);
            }
            if(isset($params['rate_friendly'])){
              $item->setRateFriendly($params['rate_friendly']);
            }
            if(isset($params['rate_tidiness'])){
              $item->setRateTidiness($params['rate_tidiness']);
            }
            if(isset($params['rate_value'])){
              $item->setRateValue($params['rate_value']);
            }

            $rateTotal = round((($item->getRateTimeManagement() + $item->getRateFriendly() + $item->getRateTidiness() + $item->getRateValue()) / 4), 0, PHP_ROUND_HALF_UP);
            $item->setRateTotal($rateTotal);
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
     * @Route("/api/v1/review_items/{id}", name="delete_review_item")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle\Entity\Review\Item\Item')->find($id);

        if(!is_object($item)){
            $item = $em->getRepository('AppBundle\Entity\Review\Item\Item')->findOneBy(array('expert_trades_review_id' => $id));
        }

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
