<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Gallery\Item\Item;
use AppBundle\Entity\Gallery\Tag\Tag;
use AppBundle\Entity\Gallery\Tag\ItemTag;

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
          'type_pagination' => $gallery->getTypePagination(),
          'type_tags' => $gallery->getTypeTags(),
          'meta_title' => $gallery->getMetaTitle(),
          'meta_description' => $gallery->getMetaDescription()
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
             
             if(isset($params['type_pagination'])){
               $gallery->setTypePagination($params['type_pagination']);
             }
         
             if(isset($params['type_tags'])){
               $gallery->setTypeTags($params['type_tags']);
             }

             if(isset($params['meta_title'])){
               $gallery->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $gallery->setMetaDescription($params['meta_description']);
             }

             $em->persist($gallery);
             $em->flush();

             $response = new Response(json_encode(
             [
               'id' => 200,
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

      $path = 'http://'.$request->server->get('HTTP_HOST').'/images/gallery/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/gallery/';
      }

      $limit = $request->query->get('limit');
      $limit = (is_null($limit)) ? 10 : $limit;

      $offset = $request->query->get('offset');
      $offset = (is_null($offset)) ? 0 : $offset;

      $filters = [];
      if($request->query->has('search')){
      	$filters['search'] =  $request->query->get('search');
      }
      if($request->query->has('tags')){
      	$filters['tags'] =  $request->query->get('tags');
      }
      
      $images =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')
      ->getPaginated($limit, $offset, $filters, $path);

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

      $path = 'http://'.$request->server->get('HTTP_HOST').'/images/gallery/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/gallery/';
      }
      $tags = [];
      foreach($image->getItemTags() as $item_tag){
      	$tag = $item_tag->getTag();
      	$tags[] = $tag->getId();
      }
		
      $response = new Response(json_encode([
        'id' => $image->getId(),
        'title' => $image->getTitle(),
        'order' => $image->getOrder(),
        'image_url' => (is_null($image->getPath())) ? null : $path.$image->getPath(),
        'tags_id' => $tags
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
            
            if(isset($params['order'])){
            	$item->setOrder($params['order']);
            }

            if(isset($params['rotate']) && $params['rotate'] != 0){
            	//function rotate image
            	$item->rotateImage( $params['rotate'] );
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
            'id' => $item->getId()
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
    


    /**
     * @Route("/api/v1/gallery_tags/{id}", name="get_gallery_tag")
     * @Method({"GET"})
     * 
     * Get TAG.
     *
     * @param Trade $trade
     * @param int     $id
     *
     * @return array
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getGalleryTagAction(Request $request, $id)
    {
      	$this->checkAccess($request);
      	
      	$em = $this->getDoctrine()->getManager();
      	$tag =  $em->getRepository('AppBundle\Entity\Gallery\Tag\Tag')->find($id);
      	
      	$response = new Response(json_encode(
      			[
      					'bgcolor' => $tag->getBgColor(),
      					'color' => $tag->getColor(),
      					'has_childs' => $tag->hasChildren(),
      					'id' => $tag->getId(),
      					'name' => $tag->getName(),
      					'path' => $tag->getPath()
      			]));
      	$response->headers->set('Content-Type', 'application/json');
      	
      	return $response;
    }
    

    /**
     * @Route("/api/v1/gallery_tags", name="get_gallery_tags", requirements={"offset" = "\d+", "limit" = "\d+", "search" = "\s+"}, defaults={"offset" = 0, "limit" = 10, "search" = null})
     * @Method({"GET"})
     */
    public function getGalleryTagsAction(Request $request)
    {
      	$this->checkAccess($request);
      	$em = $this->getDoctrine()->getManager();
      	
      	
      	$limit = $request->query->get('limit');
      	$limit = (is_null($limit)) ? 10 : $limit;
      	
      	$offset = $request->query->get('offset');
      	$offset = (is_null($offset)) ? 0 : $offset;
      	
      	$search = $request->query->get('search');
      	
      	$tags_images =  $em->getRepository('AppBundle\Entity\Gallery\Tag\Tag')
      	->search(array('search' => $search),array('path' => 'ASC'));
      	
      	$response = new Response(json_encode(["total" => count($tags_images), "data"=>$tags_images] ));
      	$response->headers->set('Content-Type', 'application/json');
      	
      	return $response;
      	
    }
    
    
    /**
     * @Route("/api/v1/gallery_tags", name="post_gallery_tag")
     * @Method({"POST"})
     */
    public function postGalleryTagAction(Request $request)
    {
    	$this->checkAccess($request);
    	$em = $this->getDoctrine()->getManager();
    
    	$tag = new Tag();
    	//$item =  $em->getRepository('AppBundle\Entity\Gallery\Tag\Tag')->find($id);

        $content = $this->get("request")->getContent();
        if (!empty($content))
        {

        	$params = json_decode($content, true); // 2nd param to get as array
        }
        else 
        {
        	$params = $request->request->all();
        }
        if(!empty($params)){
            
        	 
            if(isset($params['bgcolor'])){
                $tag->setBgColor($params['bgcolor']);
            }
            
            if(isset($params['color'])){
            	$tag->setColor($params['color']);
            }
            
            if(isset($params['name'])){
            	$tag->setName($params['name']);
            	$tag->setPath( $this->parseNonAlphanumerics($params['name']) );
            }           

            $em->persist($tag);
            $em->flush();

            $response = new Response(json_encode(
            [
              'code' => 200,
              'message' => 'OK',
              'data' => [
      					'bgcolor' => $tag->getBgColor(),
      					'color' => $tag->getColor(),
      					'has_childs' => $tag->hasChildren(),
      					'id' => $tag->getId(),
      					'name' => $tag->getName(),
      					'path' => $tag->getPath()
      			]
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
     * @Route("/api/v1/gallery_tags/{id}", name="put_gallery_tag")
     * @Method({"PUT"})
     */
    public function putGalleryTagAction(Request $request, $id)
    {
    	$this->checkAccess($request);
    
    	$em = $this->getDoctrine()->getManager();
    
    	//$tag = new Tag();
    	$tag =  $em->getRepository('AppBundle\Entity\Gallery\Tag\Tag')->find($id);

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {

        	$params = json_decode($content, true); // 2nd param to get as array
        }
        else 
        {
        	$params = $request->request->all();
        }
        
        
        
        if (!is_object($tag) ){
        	$response = new Response(json_encode(
        			[
        					'code' => 1,
        					'message' => 'Tag didn\'t exist'
        			]));
        }
        else if(!empty($params))
        {
            
            if(isset($params['bgcolor'])){
                $tag->setBgColor($params['bgcolor']);
            }
            
            if(isset($params['color'])){
            	$tag->setColor($params['color']);
            }
            
            if(isset($params['name'])){
            	$tag->setName($params['name']);
            	$tag->setPath( $this->parseNonAlphanumerics($params['name']) );
            }           

            $em->persist($tag);
            $em->flush();

            $response = new Response(json_encode(
            [
              'code' => 200,
              'message' => 'OK',
              'data' => [
      					'bgcolor' => $tag->getBgColor(),
      					'color' => $tag->getColor(),
      					'has_childs' => $tag->hasChildren(),
      					'id' => $tag->getId(),
      					'name' => $tag->getName(),
      					'path' => $tag->getPath()
      			]
            ]));

        }else {

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
     * @Route("/api/v1/gallery_tags/{id}", name="delete_gallery_tag")
     * @Method({"DELETE"})
     */
    public function deleteGalleryTagAction(Request $request, $id)
    {
    	$this->checkAccess($request);
    
    	$em = $this->getDoctrine()->getManager();
    	$tag =  $em->getRepository('AppBundle\Entity\Gallery\Tag\Tag')->find($id);
    
    	if(is_object($tag)){
    
    		$em->remove($tag);
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
     * @Route("/api/v1/gallery_item_tags", name="post_gallery_item_tag")
     * @Method({"POST"})
     */
    public function postGalleryItemTagAction(Request $request)
    {
    	$this->checkAccess($request);
    
    	$message = null;
    	$final_response = [];
    	$final_response2 = [];
    	 
    	$content = $this->get("request")->getContent();
    	if (!empty($content))
    	{
    	
    		$params = json_decode($content, true); // 2nd param to get as array
    	}
    	else
    	{
    		$params = $request->request->all();
    	}
    	if(empty($params)){
    		$message = "Invalid form";
    	}
    	if(isset($params['tags_delete_ids'])){

	    	$final_response = $this->deleteByIds($params['items_ids'],$params['tags_delete_ids'], true );
	    	if(!is_array($final_response)){
	    	    $message = $final_response;
	    	    $final_response = [];
    	    }
    	}
    	
    	if(isset($params['tags_ids'])){
	    	$final_response2 = $this->postByIds($params['items_ids'],$params['tags_ids'] );
	    	if(!is_array($final_response2)){
	    		$message = $final_response2;
	    		$final_response2 = [];
	    	}
    		
    	}
    	
    	if(is_null($message) )
    	{
    		$response = new Response(json_encode(
    				array_merge($final_response2,$final_response)
    				));
    	}
    	else
    	{
       		$response = new Response(json_encode(
    				[
    						'code' => 1,
    						'message' => $message
    				]));
    	}
    
    	$response->headers->set('Content-Type', 'application/json');
    	return $response;
    }
    
    
    /**
     * @Route("/api/v1/gallery_item_tags/delete", name="post_gallery_item_tag_delete")
     * @Method({"POST"})
     */
    public function postGalleryItemTagDeleteAction(Request $request)
    {
    	$content = $this->get("request")->getContent();
    	if (!empty($content))
    	{
    	
    		$params = json_decode($content, true); // 2nd param to get as array
    	}
    	else
    	{
    		$params = $request->request->all();
    	}
    	if(isset($params['tags_delete_ids']) && isset($params['delete'])){
    		$final_response = $this->deleteByIds($params['items_ids'],$params['tags_delete_ids'],$params['delete'] );
    		if(!is_array($final_response))
    		{
    			$response = new Response(json_encode(
    				[
    						'code' => 1,
    						'message' => $final_response
    				]));
    		} 
    		else 
    		{
    			$response = new Response(json_encode(
    					[
    							'code' => 200,
    							'message' => 'OK'
    					]));
    		}
    	
    	}
    	else
    	{
    		$response = new Response(json_encode(
    				[
    						'code' => 1,
    						'message' => 'Invalid variables'
    				]));
    	}
    	
    	$response->headers->set('Content-Type', 'application/json');
    	return $response;
    }

    public function deleteByIds( $items_ids, $tags_ids, $delete ){
    	
    	$em = $this->getDoctrine()->getManager();

    	if( $delete !== 'DELETE' &&  $delete !== true &&  $delete !== 'true'  ){
    		return $this->error(1, 'You need to accept delete terms');
    	}
    	if(!is_array($items_ids) && is_string($items_ids)){
    		$items_ids = json_decode($items_ids, true);
    	}
    	if(!is_array($items_ids) || count($items_ids) <= 0){
    		return 'We can set items with tags without tags ids.';
    	}
    	if(!is_array($tags_ids) && is_string($tags_ids)){
    		$tags_ids = json_decode($tags_ids, true);
    	}
    	if(!is_array($tags_ids) || count($tags_ids) <= 0){
    		return 'We can set items with tags without tags ids.';
    	}
    	$final_response = [
    			'success_delete' =>  0,
    			'errors' => [],
    			'total_errors' =>0
    	];
    	foreach($tags_ids as $t_id){
    		try{
    			$tag = $em->getRepository('AppBundle\Entity\Gallery\Tag\Tag')->find($t_id);
    			foreach($items_ids as $c_id){
    				try{
    					$item_tag =  $em->getRepository('AppBundle\Entity\Gallery\Tag\ItemTag')->findOneBy(array('item'=>$c_id, 'tag'=>$tag->getId()));
    					if( !is_null($item_tag) ){
    						$em->remove($item_tag);
    						$em->flush();
    					}
    					$final_response['success_delete']++;
    				} catch (\Exception $e){
    					$final_response['total_errors']++;
    					$final_response['errors'][] = $e->getMessage();
    				}
    			}
    		} catch (\Exception $e){
    			$final_response['total_errors']++;
    			$final_response['errors'][] = $e->getMessage();
    		}
    	}
    	$final_response;
    }
    
    public function postByIds( $items_ids, $tags_ids ){
    	$em = $this->getDoctrine()->getManager();
    	if(!is_array($items_ids) && is_string($items_ids)){
    		$items_ids = json_decode($items_ids, true);
    	}
    	if(!is_array($items_ids) || count($items_ids) <= 0){
    		return  'We can set items with tags without tags ids.';
    	}
    	if(!is_array($tags_ids) && is_string($tags_ids)){
    		$tags_ids = json_decode($tags_ids, true);
    	}
    	if(!is_array($tags_ids) || count($tags_ids) <= 0){
    		return 'We can set items with tags without tags ids.';
    	}
    	$final_response2 = [
    			'success_tags' =>  0,
    			'success_items' =>  0,
    			'total_error_tags' =>0,
    			'error_tags' => [],
    			'total_error_items' =>0,
    			'error_items' => []
    	];
    	foreach($tags_ids as $t_id){
    		try{
    			$tag = $em->getRepository('AppBundle\Entity\Gallery\Tag\Tag')->find($t_id);
    			$final_response2['success_tags']++;
    			foreach($items_ids as $c_id){
    				try{
    					$item = $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->find($c_id);
    					$item_tag = $em->getRepository('AppBundle\Entity\Gallery\Tag\ItemTag')->findOneBy(array('item'=>$item->getId(), 'tag'=>$tag->getId()));
    					if( is_null($item_tag) ){
    						$item_tag = new ItemTag();
    						$item_tag->setItem($item);
    						$item_tag->setTag($tag);
    						$em->persist($item_tag);
    						$em->flush();
    						$final_response2['success_items']++;
    					}
    				}catch(\Exception $e){
    					$final_response2['total_error_items']++;
    					$final_response2['error_items'][] = $e->getMessage();
    				}
    			}
    		} catch (\Exception $e){
    			$final_response2['total_error_tags']++;
    			$final_response2['error_tags'][] = $e->getMessage();
    		}
    	}
    	return $final_response2;
    }
    
    
    /**
     * Get an entity.
     *
     * @param string $text
     *
     * @return string
     */
    public function parseNonAlphanumerics($text,$replace = '-')
    {
    	return preg_replace("/[^A-Za-z0-9 ]/", $replace, $text);
    }
}
