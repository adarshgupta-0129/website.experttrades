<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Page\Page;
use AppBundle\Entity\Page\Item\Item;
use Symfony\Component\Validator\Constraints\IsNull;


class PageController extends SecurityController
{
	
	/**
	 * @Route("/api/v1/pages", name="get_pages", requirements={"offset" = "\d+", "limit" = "\d+"}, defaults={"offset" = 0, "limit" = 10})
	 * @Method({"GET"})
	 */
	public function getPagesAction(Request $request)
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
	
		$pages =  $em->getRepository('AppBundle\Entity\Page\Page')
		->getAllPaginated($limit, $offset,$filters);
	
		$response = new Response(json_encode($pages));
		$response->headers->set('Content-Type', 'application/json');
	
		return $response;
	
	}
	
	/**
	 * @Route("/api/v1/pages/{id}", name="get_page")
	 * @Method({"GET"})
	 */
	public function getPageAction(Request $request, $id)
	{
		$this->checkAccess($request);
	
		$em = $this->getDoctrine()->getManager();
		$page =  $em->getRepository('AppBundle\Entity\Page\Page')->find($id);
	
	
		$path = 'http://'.$request->server->get('HTTP_HOST').'/';
		if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
			$path = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/';
		}
		/*$items =  [];
		 foreach( $page->getItems() as $item){
		 $arrItem = [
		 'id' => $item->getId(),
		 'featured' => $item->getFeatured(),
		 'title' => $item->getTitle(),
		 'item_url' => (is_null($item->getPath())) ? null : $path.$item->getPath()
		 ];
		 $items[] = $arrItem;
		 }*/
		$objItem = $page->getFeaturedItem();
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
				'id' => $page->getId(),
				'title' => $page->getTitle(),
				'slug' => $page->getSlug(),
				'body' => $page->getBody(),
				'publish' => (is_null($page->getPublish()))?null:$page->getPublish()->getTimestamp(),
				'static_page_name' => $page->getStaticPageName(),
				'show_menu' => $page->getShowMenu(),
				'meta_tags' => $page->getMetaTags(),
				'tag_style' => $page->getTagStyle(),
				'tag_script' => $page->getTagScript(),
				'featured_image' => $item
		]));
		$response->headers->set('Content-Type', 'application/json');
	
		return $response;
	
	}
	
	/**
	 * @Route("/api/v1/pages", name="post_page")
	 * @Method({"POST"})
	 */
	public function postPageAction(Request $request)
	{
	
		$this->checkAccess($request);
	
		$em = $this->getDoctrine()->getManager();
		$page = new Page();
	
		$params = array();
		$content = $this->get("request")->getContent();
		try{
			if (!empty($content))
			{
				$params = json_decode($content, true); // 2nd param to get as array
	
	
				if(isset($params['title'])){
					$page->setTitle($params['title']);
				}
				if(isset($params['slug'])){
					if( $em->getRepository('AppBundle\Entity\Page\Page')->checkSlug( $params['slug'] ) <= 0 )
						$page->setSlug($params['slug']);
						else
							throw new \Exception('This slug already exist.');
				}
				if(isset($params['body'])){
					$page->setBody($params['body']);
				}
				if(isset($params['publish'])){
					$page->setPublish( (new \DateTime())->setTimestamp($params['publish']) );
					$page->setActive(true);
				}
				if(isset($params['static_page_name'])){
					$page->setStaticPageName($params['static_page_name']);
				}
				if(isset($params['show_menu'])){
					$page->setShowMenu($params['show_menu']);
				}
				if(isset($params['meta_tags'])){
					$page->setMetaTags($params['meta_tags']);
				}
				if(isset($params['tag_style'])){
					$page->setTagStyle($params['tag_style']);
				}
				if(isset($params['tag_style'])){
					$page->setTagScript($params['tag_style']);
				}
				if(isset($params['active'])){
					$page->active();
				}
	
				$em->persist($page);
				$em->flush();
	
				$response = new Response(json_encode(
						[
								'code' => 200,
								'message' => 'OK',
								'id' => $page->getId()
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
	 * @Route("/api/v1/pages/{id}", name="put_page")
	 * @Method({"PUT"})
	 */
	public function putPageAction(Request $request, $id)
	{
		$this->checkAccess($request);
	
		$em = $this->getDoctrine()->getManager();
		$page =  $em->getRepository('AppBundle\Entity\Page\Page')->find($id);
	
		$params = array();
		$content = $this->get("request")->getContent();
		try{
			if (!empty($content))
			{
				$params = json_decode($content, true); // 2nd param to get as array
				if(isset($params['title'])){
					$page->setTitle($params['title']);
				}
				if(isset($params['slug'])){
					if( $em->getRepository('AppBundle\Entity\Page\Page')->checkSlug( $params['slug'], $id ) <= 0 )
						$page->setSlug($params['slug']);
						else
							throw new \Exception('This slug already exist.');
				}
				if(isset($params['body'])){
					$page->setBody($params['body']);
				}
			
				if(isset($params['slug'])){
					if( $em->getRepository('AppBundle\Entity\Page\Page')->checkSlug( $params['slug'] ) <= 0 )
						$page->setSlug($params['slug']);
						else
							throw new \Exception('This slug already exist.');
				}
				if(isset($params['body'])){
					$page->setBody($params['body']);
				}
				if(isset($params['publish'])){
					$page->setPublish( (new \DateTime())->setTimestamp($params['publish']) );
					$page->setActive(true);
				}
				if(isset($params['static_page_name'])){
					$page->setStaticPageName($params['static_page_name']);
				}
				if(isset($params['show_menu'])){
					$page->setShowMenu($params['show_menu']);
				}
				if(isset($params['meta_tags'])){
					$page->setMetaTags($params['meta_tags']);
				}
				if(isset($params['tag_style'])){
					$page->setTagStyle($params['tag_style']);
				}
				if(isset($params['tag_style'])){
					$page->setTagScript($params['tag_style']);
				}
				if(isset($params['active'])){
					$page->active();
				}
				$em->persist($page);
				$em->flush();
				$response = new Response(json_encode(
						[
								'code' => 200,
								'message' => 'OK',
								'id' => $page->getId()
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
	 * @Route("/api/v1/pages/{id}", name="delete_page")
	 * @Method({"DELETE"})
	 */
	public function deletePageAction(Request $request, $id)
	{
		$this->checkAccess($request);
	
		$em = $this->getDoctrine()->getManager();
		$page =  $em->getRepository('AppBundle\Entity\Page\Page')->find($id);
	
		if(is_object($page)){
			foreach( $page->getItems() as $item ){
				$this->deletePageFileAction($request, $page->getId(), $item->getId());
			}
			$em->remove($page);
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
	 * @Route("/api/v1/pages/{id}/file/{type}", name="get_page_file_img")
	 * @Method({"GET"})
	 */
	public function getPageFileImagesAction(Request $request, $id, $type)
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
		$return = $em->getRepository('AppBundle\Entity\Page\Item\Item')
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
	 * @Route("/api/v1/pages/{id}/file", name="post_page_file")
	 * @Method({"POST"})
	 */
	public function postPageFileAction(Request $request, $id)
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
				$page =  $em->getRepository('AppBundle\Entity\Page\Page')->find($id);
				$item = new Item($page);
				if(isset($_REQUEST['title'])){
					$item->setTitle($_REQUEST['title']);
				}
				if(isset($_REQUEST['featured'])){
					$item->setFeatured(filter_var($_REQUEST['featured'], FILTER_VALIDATE_BOOLEAN));
					//remove all the  featured items for this page
					$em->getRepository('AppBundle\Entity\Page\Item\Item')->clearFeaturedItems( $id );
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
	 * @Route("/api/v1/pages/{page_id}/file/{id}", name="delete_page_file")
	 * @Method({"DELETE"})
	 */
	public function deletePageFileAction(Request $request, $page_id, $id)
	{
		$this->checkAccess($request);
	
		$em = $this->getDoctrine()->getManager();
		$item =  $em->getRepository('AppBundle\Entity\Page\Item\Item')->find($id);
	
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