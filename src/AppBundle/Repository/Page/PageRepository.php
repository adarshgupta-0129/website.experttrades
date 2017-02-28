<?php

namespace AppBundle\Repository\Page;

use AppBundle\Repository\Repository;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends Repository{
	
	public function getPaginated($limit, $offset, $filters = []){
	
		$data = $this->getEntityManager()->createQueryBuilder();
		$data->from('AppBundle\Entity\Page\Page', 'p');
		$data->where('p.publish IS NOT NULL');
		$data->andWhere('p.publish <= :date_now');
		$data->andWhere('p.active = true');
		$data->setParameter('date_now' , (new \DateTime()) );
		
		if(isset($filters['search']) && $filters['search'] != "" ){
			$data->andWhere('p.search LIKE  :search');
			$data->setParameter('search' , '%'.$filters['search'].'%');
		}
		
		$count = clone $data;
		$count->select('count(p.id)');
		$total = $count->getQuery()->getSingleScalarResult();
		
		$data->select('p');
		$data->setFirstResult($offset);
		$data->setMaxResults($limit);
		$data->orderBy('p.publish', 'desc');
		$result = $data->getQuery()->getResult();
	
		$final = [];
		foreach($result as $page){
			$result_page = [];
			$result_page['id'] = $page->getId();
			$result_page['title'] = $page->getTitle();
			$result_page['slug'] = $page->getSlug();
			$result_page['type'] = $page->getType();
			$result_page['static_page_name'] = $page->getStaticPageName();
			$result_page['redirection'] = $page->getRedirection();
			$result_page['url_redirection'] = $page->getUrlRedirection();
			$result_page['show_menu'] = $page->getShowMenu();
			$result_page['option_menu'] = $page->getOptionMenu();
			$result_page['body'] = $page->getBody();
			$result_page['header'] = $page->getHeader();
			$result_page['published'] = (is_null($page->getPublish()))?null:$page->getPublish()->getTimestamp();
			$result_page['meta_tags'] = $page->getMetaTags();
			$result_page['tag_style'] = $page->getTagStyle();
			$result_page['tag_script'] = $page->getTagScript();
			if( ($item = $page->getFeaturedItem()) !== FALSE)
				$result_page['featuredImage'] = array( 'url' => $item->getWebPath(), 'title' => $item->getTitle()  );
			
			$final[] = $result_page;
		}
	
		return $this->payload($total, $limit, $offset, $final);
	
	}
	
	public function getAllPaginated($limit, $offset, $filters = []){
	
		$data = $this->getEntityManager()->createQueryBuilder();
		$data->from('AppBundle\Entity\Page\Page', 'p');

		if(isset($filters['search']) && $filters['search'] != "" ){
			$data->where('p.search <= :search');
			$data->setParameter('search' , $filters['search'] );
		}
		if(isset($filters['search_by']) && $filters['search_by'] != "" ){
			switch ($filters['search_by']){
				case 'published':
					$data->andWhere('p.publish IS NOT NULL');
					break;
				case 'unpublished':
					$data->andWhere('p.publish IS NULL');
					break;
			}
		}
		if(isset($filters['search_by_type']) && $filters['search_by_type'] != "" ){
			switch ($filters['search_by_type']){
				case 'page':
					$data->andWhere('p.type = 0');
					break;
				case 'redirection':
					$data->andWhere('p.type = 1');
					break;
				case 'static':
					$data->andWhere('p.type = 2');
					break;
			}
		}
		
		if(!isset($filters['is_admin']) || $filters['is_admin'] != true ){
			$data->andWhere('p.is_admin = true');
		}
	
		$count = clone $data;
		$count->select('count(p.id)');
		$total = $count->getQuery()->getSingleScalarResult();
	
		$data->select('p');
		$data->setFirstResult($offset);
		$data->setMaxResults($limit);
		$data->orderBy('p.publish', 'desc');
		$result = $data->getQuery()->getResult();
	
		$final = [];
		foreach($result as $page){
			$result_page = [];
			$result_page['id'] = $page->getId();
			$result_page['title'] = $page->getTitle();
			$result_page['slug'] = $page->getSlug();
			$result_page['type'] = $page->getType();
			$result_page['static_page_name'] = $page->getStaticPageName();
			$result_page['redirection'] = $page->getRedirection();
			$result_page['url_redirection'] = $page->getUrlRedirection();
			$result_page['show_menu'] = $page->getShowMenu();
			$result_page['option_menu'] = $page->getOptionMenu();
			$result_page['body'] = $page->getBody();
			$result_page['header'] = $page->getHeader();
			$result_page['published'] = (is_null($page->getPublish()))?null:$page->getPublish()->getTimestamp();
			$result_page['meta_tags'] = $page->getMetaTags();
			$result_page['tag_style'] = $page->getTagStyle();
			$result_page['tag_script'] = $page->getTagScript();
			if( ($item = $page->getFeaturedItem()) !== FALSE)
				$result_page['featuredImage'] = array( 'url' => $item->getWebPath(), 'title' => $item->getTitle()  );
			
			$final[] = $result_page;
		}
	
		return $this->payload($total, $limit, $offset, $final);
	
	}
	
	public function getMenuPages(  ){
		$option = 0;
		$return = [];
		while( $option <= 2){
			$data = $this->getEntityManager()->createQueryBuilder();
			$data->from('AppBundle\Entity\Page\Page', 'p');
			$data->where('p.publish IS NOT NULL');
			$data->andWhere('p.publish <= :date_now');
			$data->andWhere('p.show_menu = true');
			$data->andWhere('p.option_menu = :option');
			$data->andWhere('p.active = true');
			$data->setParameters(array('date_now' => (new \DateTime()), 'option' => $option  ));
			$data->select('p');
			$data->orderBy('p.publish', 'desc');
			$result = $data->getQuery()->getResult();
			
			$final = [];
			foreach($result as $page){
				$result_page = [];
				$result_page['id'] = $page->getId();
				$result_page['title'] = $page->getTitle();
				$result_page['slug'] = $page->getSlug();
				$result_page['type'] = $page->getType();
				$result_page['static_page_name'] = $page->getStaticPageName();
				$result_page['redirection'] = $page->getRedirection();
				$result_page['url_redirection'] = $page->getUrlRedirection();
				$result_page['show_menu'] = $page->getShowMenu();
				$result_page['option_menu'] = $page->getOptionMenu();
				$result_page['body'] = $page->getBody();
				$result_page['header'] = $page->getHeader();
				$result_page['published'] = (is_null($page->getPublish()))?null:$page->getPublish()->getTimestamp();
				$result_page['meta_tags'] = $page->getMetaTags();
				$result_page['tag_style'] = $page->getTagStyle();
				$result_page['tag_script'] = $page->getTagScript();
				if( ($item = $page->getFeaturedItem()) !== FALSE)
					$result_page['featuredImage'] = array( 'url' => $item->getWebPath(), 'title' => $item->getTitle()  );
						
				$final[] = $result_page;
			}
			$return[$option] = $final;
			$option++;
		}
		//var_dump($return);die();
		return $return;
	
	}
	
	public function countPages(){
	
		$data = $this->getEntityManager()->createQueryBuilder();
		$data->from('AppBundle\Entity\Page\Page', 'p');
		$data->where('p.publish IS NOT NULL');
		$data->andWhere('p.publish >= :date_now');
		$data->setParameters(array('date_now' => (new \DateTime()) ));
		$count = clone $data;
		$count->select('count(p.id)');
		$total = $count->getQuery()->getSingleScalarResult();
	
		return $total;
	
	}
	

	public function checkSlug( $slug, $id = null ){
	
		$data = $this->getEntityManager()->createQueryBuilder();
		$data->from('AppBundle\Entity\Page\Page', 'p');
		$data->where('p.slug = :slug');
		$data->setParameter('slug',$slug);
		if(!is_null($id)){
			$data->andWhere('p.id != :id');
			$data->setParameter('id', $id);
		}
		$count = clone $data;
		$count->select('count(p.id)');
		$total = $count->getQuery()->getSingleScalarResult();
	
		return $total;
	
	}


}
