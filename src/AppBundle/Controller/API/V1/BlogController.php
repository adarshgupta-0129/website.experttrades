<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Blog\Blog;
use AppBundle\Entity\Blog\Post\Post;
use AppBundle\Entity\Blog\Post\Item\Item;
use Symfony\Component\Validator\Constraints\IsNull;

class BlogController extends SecurityController
{
    /**
     * @Route("/api/v1/blog", name="get_blog")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);

        $response = new Response(json_encode(
        [
          'id' => $blog->getId(),
          'header_text' => $blog->getHeaderText(),
          'header_title' => $blog->getHeaderTitle(),
          'active' => $blog->getActive(),
          'meta_title' => $blog->getMetaTitle(),
          'meta_description' => $blog->getMetaDescription()
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/blog", name="post_blog")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
         $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();
         $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
         if( !is_object($blog))
         	$blog = new Blog();

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['header_text'])){
               $blog->setHeaderText($params['header_text']);
             }
             if(isset($params['header_title'])){
               $blog->setHeaderTitle($params['header_title']);
             }
             if(isset($params['active'])){
               $blog->setActive($params['active']);
             }

             if(isset($params['meta_title'])){
               $blog->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $blog->setMetaDescription($params['meta_description']);
             }

             $em->persist($blog);
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
     * @Route("/api/v1/blog/posts", name="get_blog_posts", requirements={"offset" = "\d+", "limit" = "\d+"}, defaults={"offset" = 0, "limit" = 10})
     * @Method({"GET"})
     */
    public function getPostsAction(Request $request)
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

      $posts =  $em->getRepository('AppBundle\Entity\Blog\Post\Post')
      ->getAllPaginated($limit, $offset,$filters);

      $response = new Response(json_encode($posts));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/blog/posts/{id}", name="get_blog_post")
     * @Method({"GET"})
     */
    public function getPostAction(Request $request, $id)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $post =  $em->getRepository('AppBundle\Entity\Blog\Post\Post')->find($id);


      $path = 'http://'.$request->server->get('HTTP_HOST');
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
      }
      /*$items =  [];
      foreach( $post->getItems() as $item){
      	$arrItem = [
      		'id' => $item->getId(),
      		'featured' => $item->getFeatured(),
      		'title' => $item->getTitle(),
      		'item_url' => (is_null($item->getPath())) ? null : $path.$item->getPath()
      	];
      	$items[] = $arrItem;
      }*/
      $objItem = $post->getFeaturedItem();
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
        'id' => $post->getId(),
        'title' => $post->getTitle(),
        'slug' => $post->getSlug(),
        'excerpt' => $post->getExcerpt(),
        'body' => $post->getBody(),
        'publish' => (is_null($post->getPublish()))?null:$post->getPublish()->getTimestamp(),
        'meta_title' => $post->getMetaTitle(),
        'meta_description' => $post->getMetaDescription(),
      	'featured_image' => $item
      ]));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/blog/posts", name="post_blog_post")
     * @Method({"POST"})
     */
    public function postPostAction(Request $request)
    {

        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $post = new Post($blog);

        $params = array();
        $content = $this->get("request")->getContent();
        try{
        if (!empty($content))
        {
        	$params = json_decode($content, true); // 2nd param to get as array


        	if(isset($params['title'])){
        		$post->setTitle($params['title']);
        	}
        	if(isset($params['slug'])){
        		if( $em->getRepository('AppBundle\Entity\Blog\Post\Post')->checkSlug( $params['slug'] ) <= 0 )
        			$post->setSlug($params['slug']);
        		else
        			throw new \Exception('This slug already exist.');
        	}
        	if(isset($params['excerpt'])){
        		$post->setExcerpt($params['excerpt']);
        	}
        	if(isset($params['body'])){
        		$post->setBody($params['body']);
        	}
        	if(isset($params['publish'])){
        		$post->setPublish( (new \DateTime())->setTimestamp($params['publish']) );
        	}
             if(isset($params['meta_title'])){
               $post->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $post->setMetaDescription($params['meta_description']);
             }

	        $em->persist($post);
	        $em->flush();

        	$response = new Response(json_encode(
            [
              'code' => 200,
              'message' => 'OK',
              'id' => $post->getId()
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
     * @Route("/api/v1/blog/posts/{id}", name="put_blog_post")
     * @Method({"PUT"})
     */
    public function putPostAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $post =  $em->getRepository('AppBundle\Entity\Blog\Post\Post')->find($id);

        $params = array();
        $content = $this->get("request")->getContent();
        try{
        if (!empty($content))
        {
        	$params = json_decode($content, true); // 2nd param to get as array
        	if(isset($params['title'])){
        		$post->setTitle($params['title']);
        	}
        	if(isset($params['slug'])){
        		if( $em->getRepository('AppBundle\Entity\Blog\Post\Post')->checkSlug( $params['slug'], $id ) <= 0 )
        			$post->setSlug($params['slug']);
        		else
        			throw new \Exception('This slug already exist.');
        	}
        	if(isset($params['excerpt'])){
        		$post->setExcerpt($params['excerpt']);
        	}
        	if(isset($params['body'])){
        		$post->setBody($params['body']);
        	}
        	if((is_null($params['publish']) || $params['publish'] == 'null') ){
        		$post->setPublish(null);
        	}else if(isset($params['publish'])){
        		$post->setPublish((new \DateTime())->setTimestamp($params['publish']));
        	}
             if(isset($params['meta_title'])){
               $post->setMetaTitle($params['meta_title']);
             }
             if(isset($params['meta_description'])){
               $post->setMetaDescription($params['meta_description']);
             }

	        $em->persist($post);
	        $em->flush();
            $response = new Response(json_encode(
            [
              'code' => 200,
              'message' => 'OK',
              'id' => $post->getId()
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
     * @Route("/api/v1/blog/posts/{id}", name="delete_blog_post")
     * @Method({"DELETE"})
     */
    public function deletePostAction(Request $request, $id)
    {
    	$this->checkAccess($request);

    	$em = $this->getDoctrine()->getManager();
    	$post =  $em->getRepository('AppBundle\Entity\Blog\Post\Post')->find($id);

    	if(is_object($post)){
    		foreach( $post->getItems() as $item ){
    			$this->deletePostFileAction($request, $post->getId(), $item->getId());
    		}
    		$em->remove($post);
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
     * @Route("/api/v1/blog/posts/{id}/file/{type}", name="get_blog_post_file_img")
     * @Method({"GET"})
     */
    public function getPostFileImagesAction(Request $request, $id, $type)
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
<<<<<<< HEAD
      	$path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
      } 
      $return = $em->getRepository('AppBundle\Entity\Blog\Post\Item\Item')
      ->getPaginated($limit, $offset,$filters,$path);
      
      if( !is_null($limit)&& !is_null($offset))
      {
	      $response = new Response(json_encode($return));
      }
	  else 
	  {
	      $response = new Response(json_encode(array('items'=>$return)));
	  }		
=======
        $path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
      }
      foreach( $post->getItems( $type ) as $item ){
      	$items[] = [
      			'id' => $item->getId(),
            	'title' => $item->getTitle(),
            	'url' => $path.$item->getWebPath(),
      			'featured' => $item->getFeatured()
      	];


      }

      $response = new Response(json_encode(array('items'=>$items)));
      $response->headers->set('Content-Type', 'application/json');
>>>>>>> 33d51e87389ea49e8d8fc30bc41347e4e7d2f8d6

	  $response->headers->set('Content-Type', 'application/json');
      return $response;



    }


    /**
     * @Route("/api/v1/blog/posts/{id}/file", name="post_blog_post_file")
     * @Method({"POST"})
     */
    public function postPostFileAction(Request $request, $id)
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
          $post =  $em->getRepository('AppBundle\Entity\Blog\Post\Post')->find($id);
          $item = new Item($post);
          if(isset($_REQUEST['title'])){
          	$item->setTitle($_REQUEST['title']);
          }
          if(isset($_REQUEST['featured'])){
          	$item->setFeatured(boolval($_REQUEST['featured']));
          	//remove all the  featured items for this post
          	$em->getRepository('AppBundle\Entity\Blog\Post\Item\Item')->clearFeaturedItems( $id );
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
     * @Route("/api/v1/blog/posts/{post_id}/file/{id}", name="delete_blog_post_file")
     * @Method({"DELETE"})
     */
    public function deletePostFileAction(Request $request, $post_id, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Blog\Post\Item\Item')->find($id);

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
