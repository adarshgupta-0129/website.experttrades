<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Offerpage\OfferPage;
use AppBundle\Entity\Offerpage\Offer\Offer;
use AppBundle\Entity\Offerpage\Offer\Item\Item;
use Symfony\Component\Validator\Constraints\IsNull;

class OfferpageController extends SecurityController
{
    /**
     * @Route("/api/v1/offerpage", name="get_offerpage")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $offerpage =  $em->getRepository('AppBundle\Entity\Offerpage\OfferPage')->find(1);
        $response = new Response(json_encode(
        [
          'id' => $offerpage->getId(),
          'header_text' => $offerpage->getHeaderText(),
          'header_title' => $offerpage->getHeaderTitle(),
          'active' => $offerpage->getActive(),
          'meta_title' => $offerpage->getMetaTitle(),
          'meta_description' => $offerpage->getMetaDescription()
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/offerpage", name="offer_offerpage")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
         $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();
         $offerpage =  $em->getRepository('AppBundle\Entity\Offerpage\OfferPage')->find(1);
         if( !is_object($offerpage))
         	$offerpage = new Offerpage();

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['header_text'])){
               $offerpage->setHeaderText($params['header_text']);
             }
             if(isset($params['header_title'])){
               $offerpage->setHeaderTitle($params['header_title']);
             }
             if(isset($params['active'])){
               $offerpage->setActive($params['active']);
             }

             if(isset($params['meta_title'])){
               $offerpage->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $offerpage->setMetaDescription($params['meta_description']);
             }

             $em->persist($offerpage);
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
     * @Route("/api/v1/offerpage/offers", name="get_offerpage_offers", requirements={"offset" = "\d+", "limit" = "\d+"}, defaults={"offset" = 0, "limit" = 10})
     * @Method({"GET"})
     */
    public function getOffersAction(Request $request)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();

      $limit = $request->query->get('limit');
      $limit = (is_null($limit)) ? 10 : $limit;

      $offset = $request->query->get('offset');
      $offset = (is_null($offset)) ? 0 : $offset;
      $filters = [];
      if( $request->query->get('search') != "" ){
      	$filters['search'] = $request->query->get('search');
      }

      if( $request->query->get('search_by') != "" ){
      	$filters['search_by'] = $request->query->get('search_by');
      }


      $host = 'http://'.$request->server->get('HTTP_HOST').'/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
      	$host = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
      }

      $offers =  $em->getRepository('AppBundle\Entity\Offerpage\Offer\Offer')
      ->getAllPaginated($limit, $offset,$filters);

      foreach( $offers['data'] as &$of){
      	if(isset($of['featured_image']) && isset($of['featured_image']['url'])){
      		$of['featured_image']['url'] = $host.$of['featured_image']['url'];
      	}
      }

      $response = new Response(json_encode($offers));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/offerpage/offers/{id}", name="get_offerpage_offer")
     * @Method({"GET"})
     */
    public function getOfferAction(Request $request, $id)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $offer =  $em->getRepository('AppBundle\Entity\Offerpage\Offer\Offer')->find($id);


      $path = 'http://'.$request->server->get('HTTP_HOST').'/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
      }
      /*$items =  [];
      foreach( $offer->getItems() as $item){
      	$arrItem = [
      		'id' => $item->getId(),
      		'featured' => $item->getFeatured(),
      		'title' => $item->getTitle(),
      		'item_url' => (is_null($item->getPath())) ? null : $path.$item->getPath()
      	];
      	$items[] = $arrItem;
      }*/
      $objItem = $offer->getFeaturedItem();
      $item = null;
      if(is_object($objItem)){
	      $item = [
	      		'id' => $objItem->getId(),
	      		'featured' => $objItem->getFeatured(),
	      		'title' => $objItem->getTitle(),
	      		'url' => (is_null($objItem->getWebPath())) ? null : $path.$objItem->getWebPath()
	      	];
      }

      $response = new Response(json_encode([
        'id' => $offer->getId(),
        'title' => $offer->getTitle(),
        'slug' => $offer->getSlug(),
        'excerpt' => $offer->getExcerpt(),
        'body' => $offer->getBody(),
        'is_published' => $offer->isPublished(),
        'show_homepage' => $offer->getShowHomepage(),
        'active' => $offer->getActive(),
        'publish' => (is_null($offer->getPublish()))?null:$offer->getPublish()->getTimestamp(),
        'publish_until' => (is_null($offer->getPublishUntil()))?null:$offer->getPublishUntil()->getTimestamp(),
        'meta_title' => $offer->getMetaTitle(),
        'meta_description' => $offer->getMetaDescription(),
        'btn_text' => $offer->getBtnText(),
        'btn_action' => $offer->getBtnAction(),
        'btn_contact_text' => $offer->getBtnContactText(),
        'btn_link' => $offer->getBtnLink(),
      	'featured_image' => $item
      ]));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/offerpage/offers", name="offer_offerpage_offer")
     * @Method({"POST"})
     */
    public function postOfferAction(Request $request)
    {

        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $offerpage =  $em->getRepository('AppBundle\Entity\Offerpage\OfferPage')->find(1);
        $offer = new Offer($offerpage);

        $params = array();
        $content = $this->get("request")->getContent();
        try{
        if (!empty($content))
        {
        	$params = json_decode($content, true); // 2nd param to get as array


        	if(isset($params['title'])){
        		$offer->setTitle($params['title']);
        	}
        	if(isset($params['slug'])){
        		if( $em->getRepository('AppBundle\Entity\Offerpage\Offer\Offer')->checkSlug( $params['slug'] ) <= 0 )
        			$offer->setSlug($params['slug']);
        		else
        			throw new \Exception('This slug already exist.');
        	}
        	if(isset($params['excerpt'])){
        		$offer->setExcerpt($params['excerpt']);
        	}
        	if(isset($params['body'])){
        		$offer->setBody($params['body']);
        	}
             if(isset($params['active'])){
               $offer->setActive($params['active']);
             }
             if(isset($params['show_homepage'])){
               $offer->setShowHomepage($params['show_homepage']);
             }
        	if(isset($params['publish']) && $params['publish'] == 0){
        		$offer->setPublish( NULL );
        	}else if(isset($params['publish']) && (is_null($params['publish']) || $params['publish'] == 'null') ){
        		$offer->setPublish(null);
        	}else if(isset($params['publish'])){
        		$offer->setPublish((new \DateTime())->setTimestamp($params['publish']));
        	}
        	if(isset($params['publish_until']) && $params['publish_until'] == 0){
        		$offer->setPublishUntil( NULL );
        	}else if( isset($params['publish_until']) && (is_null($params['publish_until']) || $params['publish_until'] == 'null') ){
        		$offer->setPublishUntil(null);
        	}else if(isset($params['publish_until'])){
        		$offer->setPublishUntil( (new \DateTime())->setTimestamp($params['publish_until']) );
        	}
             if(isset($params['meta_title'])){
               $offer->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $offer->setMetaDescription($params['meta_description']);
             }
        	if(isset($params['btn_text'])){
        		$offer->setBtnText($params['btn_text']);
        	}
        	if(isset($params['btn_action'])){
        		$offer->setBtnAction($params['btn_action']);
        	}
        	if(isset($params['btn_contact_text'])){
        		$offer->setBtnContactText($params['btn_contact_text']);
        	}
        	if(isset($params['btn_link'])){
        		$offer->setBtnLink($params['btn_link']);
        	}
        	$offer->setPublished();

	        $em->persist($offer);
	        $em->flush();

        	$response = new Response(json_encode(
            [
              'code' => 200,
              'message' => 'OK',
              'id' => $offer->getId()
            ]));

        }else{

            $response = new Response(json_encode(
            [
              'code' => 1,
              'message' => 'Invalid Form'
            ]));
        }
        } catch (\Exception $e){
        	$response = new Response(json_encode(
        			[
        					'code' => 2,
        					'message' => $e->getMessage()
        			]));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/api/v1/offerpage/offers/{id}", name="put_offerpage_offer")
     * @Method({"PUT"})
     */
    public function putOfferAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $offer =  $em->getRepository('AppBundle\Entity\Offerpage\Offer\Offer')->find($id);

        $params = array();
        $content = $this->get("request")->getContent();
        try{
        if (!empty($content))
        {
        	$params = json_decode($content, true); // 2nd param to get as array
        	if(isset($params['title'])){
        		$offer->setTitle($params['title']);
        	}
        	if(isset($params['slug'])){
        		if( $em->getRepository('AppBundle\Entity\Offerpage\Offer\Offer')->checkSlug( $params['slug'], $id ) <= 0 )
        			$offer->setSlug($params['slug']);
        		else
        			throw new \Exception('This slug already exist.');
        	}
        	if(isset($params['excerpt'])){
        		$offer->setExcerpt($params['excerpt']);
        	}
        	if(isset($params['body'])){
        		$offer->setBody($params['body']);
        	}

        	if(isset($params['show_homepage'])){
        		$offer->setShowHomepage($params['show_homepage']);
        	}
        	if(isset($params['active'])){
        		$offer->setActive($params['active']);
        	}
        	if(isset($params['publish']) && $params['publish'] == 0){
        		$offer->setPublish( NULL );
        	}else if(isset($params['publish']) && (is_null($params['publish']) || $params['publish'] == 'null') ){
        		$offer->setPublish(null);
        	}else if(isset($params['publish'])){
        		$offer->setPublish((new \DateTime())->setTimestamp($params['publish']));
        	}
        	if(isset($params['publish_until']) && $params['publish_until'] == 0){
        		$offer->setPublishUntil( NULL );
        	}else if( isset($params['publish_until']) && (is_null($params['publish_until']) || $params['publish_until'] == 'null') ){
        		$offer->setPublishUntil(null);
        	}else if(isset($params['publish_until'])){
        		$offer->setPublishUntil( (new \DateTime())->setTimestamp($params['publish_until']) );
        	}
             if(isset($params['meta_title'])){
               $offer->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $offer->setMetaDescription($params['meta_description']);
             }
        	if(isset($params['btn_text'])){
        		$offer->setBtnText($params['btn_text']);
        	}
        	if(isset($params['btn_action'])){
        		if($params['btn_action'] != 'contact' && $params['btn_action'] != 'ext_redirect' && $params['btn_action'] != 'int_redirect' )
        			$offer->setBtnAction(null);
        		else
        			$offer->setBtnAction($params['btn_action']);
        	}
        	if(isset($params['btn_contact_text'])){
        		$offer->setBtnContactText($params['btn_contact_text']);
        	}
        	if(isset($params['btn_link'])){
        		$offer->setBtnLink($params['btn_link']);
        	}

        	$offer->setPublished();
	        $em->persist($offer);
	        $em->flush();
            $response = new Response(json_encode(
            [
              'code' => 200,
              'message' => 'OK',
              'id' => $offer->getId()
            ]));

        }else{

            $response = new Response(json_encode(
            [
              'code' => 1,
              'message' => 'Invalid Form'
            ]));
        }
        } catch (\Exception $e){
        	$response = new Response(json_encode(
        			[
        					'code' => 2,
        					'message' => $e->getMessage()
        			]));
        }


        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * @Route("/api/v1/offerpage/offers/{id}", name="delete_offerpage_offer")
     * @Method({"DELETE"})
     */
    public function deleteOfferAction(Request $request, $id)
    {
    	$this->checkAccess($request);

    	$em = $this->getDoctrine()->getManager();
    	$offer =  $em->getRepository('AppBundle\Entity\Offerpage\Offer\Offer')->find($id);

    	if(is_object($offer)){
    		foreach( $offer->getItems() as $item ){
    			$this->deleteOfferFileAction($request, $offer->getId(), $item->getId());
    		}
    		$em->remove($offer);
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
     * @Route("/api/v1/offerpage/offers/{id}/file/{type}", name="get_offerpage_offer_file_img")
     * @Method({"GET"})
     */
    public function getOfferFileImagesAction(Request $request, $id, $type)
    {
    	$this->checkAccess($request);
    	$limit = $request->query->get('limit');
    	$limit = (is_null($limit) || !is_numeric($limit)) ? null : $limit;

    	$offset = $request->query->get('offset');
    	$offset = (is_null($offset) || !is_numeric($offset)) ? null : $offset;

      $em = $this->getDoctrine()->getManager();
      $filters = array('id'=> $id, 'type'=>$type);



      $path = 'http://'.$request->server->get('HTTP_HOST').'/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
      	$path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
      }
      $return = $em->getRepository('AppBundle\Entity\Offerpage\Offer\Item\Item')
      ->getPaginated($limit, $offset,$filters,$path);

      if( !is_null($limit)&& !is_null($offset))
      {
	      $response = new Response(json_encode($return));
      }
	  else
	  {
	      $response = new Response(json_encode(array('items'=>$return)));
	  }


	  $response->headers->set('Content-Type', 'application/json');
      return $response;



    }


    /**
     * @Route("/api/v1/offerpage/offers/{id}/file", name="offer_offerpage_offer_file")
     * @Method({"POST"})
     */
    public function postOfferFileAction(Request $request, $id)
    {
        $this->checkAccess($request);


        $em = $this->getDoctrine()->getManager();
        $file = $request->files->get('file');
        $isValid = false;
        $type="";
        if(isset($_REQUEST['type'])){
        	if($_REQUEST['type'] == Item::ITEM_IMAGE && in_array($file->getMimeType(), Item::$MIMETYPE[Item::ITEM_IMAGE])){
        		$isValid = true;
        		$type = Item::ITEM_IMAGE;
        	}else if($_REQUEST['type'] == Item::ITEM_PDF && in_array($file->getMimeType(), Item::$MIMETYPE[Item::ITEM_PDF])){
        		$isValid = true;
        		$type = Item::ITEM_PDF;
        	}
        }
        try{
        if(!$isValid && !is_null($file)){
        	throw new \Exception('The '.$file->getMimeType().' format is invalid');
        }elseif(!is_null($file)) {

          $params = array();
          $offer =  $em->getRepository('AppBundle\Entity\Offerpage\Offer\Offer')->find($id);
          $item = new Item($offer);
          if(isset($_REQUEST['title'])){
          	$item->setTitle($_REQUEST['title']);
          }
          if(isset($_REQUEST['featured'])){
          	$item->setFeatured(filter_var($_REQUEST['featured'], FILTER_VALIDATE_BOOLEAN));
          	//remove all the  featured items for this offer
          	$em->getRepository('AppBundle\Entity\Offerpage\Offer\Item\Item')->clearFeaturedItems( $id );
          }
          if($type != ""){
          	$item->setType($type);
          }
          $item->setFile($file);
          $item->upload();

          $em->persist($item);
          $em->flush();

          $path = 'http://'.$request->server->get('HTTP_HOST').'/';
          if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
          	$path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
          }
          $response = new Response(json_encode(
          [
            'id' => $item->getId(),
            'title' => $item->getTitle(),
            'url' => $path.$item->getWebPath(),
          	'featured' => $item->getFeatured()
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
    } catch (\Exception $e){
        	$response = new Response(json_encode(
        			[
        					'code' => 2,
        					'message' => $e->getMessage()
        			]));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * @Route("/api/v1/offerpage/offers/{offer_id}/file/{id}", name="delete_offerpage_offer_file")
     * @Method({"DELETE"})
     */
    public function deleteOfferFileAction(Request $request, $offer_id, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Offerpage\Offer\Item\Item')->find($id);

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
