<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Visit\Visit;
use AppBundle\Entity\Subscriber\Subscriber;
use AppBundle\Entity\Item\Item;

class MainController extends Controller
{


    public function trackVisit()
    {
        $em = $this->getDoctrine()->getManager();

  /*   NOT A GOOD WAY TO TRACK VISITS, TO MANY ROWS IN DB AND NOT ACCURATE
     if(!isset($_COOKIE['visit'])) {

            setcookie('visit', '1', time() + 86400, "/");

            $visit = new Visit();
            $visit->setIp();
            $em->persist($visit);
            $em->flush();

        }
        */
    }

    public function defaultInfo(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();


    	$contact =  $em->getRepository('AppBundle\Entity\Contact\Contact')->find(1);
    	$website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
    	$blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
    	$offer =  $em->getRepository('AppBundle\Entity\Offerpage\OfferPage')->find(1);
    	$homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);
    	$facebook = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_FB]);
    	$twitter = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_SOCIAL_TWITTER]);
    	$favicon = $em->getRepository('AppBundle\Entity\Item\Item')->findOneBy(['storage'=>Item::STORE_FAVICON]);
    	$facebook_image = null;
    	$twitter_image = null;
    	if(is_object($facebook))$facebook_image =( is_null($facebook->getPath())) ? null : $facebook->getWebPath();
    	if(is_object($twitter))$twitter_image = ( is_null($twitter->getPath())) ? null : $twitter->getWebPath();
    	if(is_object($favicon))$favicon = ( is_null($favicon->getPath())) ? null : $favicon->getWebPath();

    	$footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->getForDisplay(9, 0, ['tag_path'=>'footer']);
    	$footerImages = $footerImages['data'];
    	if( count($footerImages) <= 0 ){
    		$footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);
    	}
    	/* replace date copyright or introducing it copyright */ 
    	$pregrpl = preg_replace("/^©\s*20[0-9]{2}/","",$website->getCopyright(),-1, $count);
    	$year = (new \DateTime())->format('Y');
    	if($count > 0)$website->setCopyright('©'. $year . " ". $pregrpl); 
    	if( strpos($website->getCopyright(),$year) === FALSE )$website->setCopyright('©'. $year . " ". $website->getCopyright()); 
    	return array(
				'id_page' => "base",
    			'contact' => $contact,
    			'website' => $website,
    			'homepage' => $homepage,
    			'favicon' => $favicon,
    			'facebook_image' => $facebook_image,
    			'twitter_image' => $twitter_image,
    			'hasBlog' => $blog->getActive(),
    			'hasOffer' => $offer->getActive(),
    			'offer' => $offer,
    			'footer_images' => $footerImages,
    			'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['order' => 'ASC','id' => 'DESC']),
    			'nav_bar_pages' => $em->getRepository('AppBundle\Entity\Page\Page')->getMenuPages(),
    			'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll(),
          		'subscriber_form' => $this->createFormBuilder(new Subscriber())->add('email', 'text')->getForm()->createView(),
    			'margin_top_subscription' => true,
    			'snipped' => $this->richSnippedsJson($em, $request, $website, $homepage),
    			'gmaps' => $this->getUrlGmaps($website),
    	);
    }
    private function getUrlGmaps($website ){
    	return "https://www.google.com/maps/embed/v1/place?key=AIzaSyDWh2ugH_oq9rD1WRF9qH0-eIcUjEN-bEg&q=".$website->getPostcode()."&zoom=".$website->getZoomMaps()."";
    }

    public function richSnippedsJson($em, Request $request, $website, $homepage ){


    	$snipped = '<script type="application/ld+json">'
    	.'{'
    	.'	"@context": "http://schema.org/",'
    	.'	"@type": "Organization",'
    	.'	"name": "'. $website->getCompanyName() .'",'
    	.'	"description": "'. $homepage->getMetaDescription() .'",'
		.'	"url" : "'.$request->getUri().'",'
		.'	"logo" : "'.$request->getUri().'images/logo/'.$website->getLogoPath().'",';

		$contact =  $em->getRepository('AppBundle\Entity\Contact\Contact')->find(1);
		$snipped .= '"contactPoint" : {'
		.'	"@type" : "ContactPoint",'
		.'	"contactType" : "sales, customer support",';
		if( !is_null($contact->getPhone()) && trim($contact->getPhone()) != "" )
			$snipped .= '	"telephone" : "'.$contact->getFormatedPhone().'",';
		$snipped .= '	"areaServed" : "UK",'
		.'	"availableLanguage" : "English",'
		.'	"email" : "'.$contact->getEmail().'"'
		.'	}';

		$review_info = $em->getRepository('AppBundle\Entity\Review\Item\Item')->getInfoReview();
    	if(isset($review_info['num_reviews']) &&  $review_info['num_reviews'] > 0)
    	{
	    	$snipped .= ',	"aggregateRating": {'
	    	.'		"@type": "AggregateRating",'
	    	.'		"ratingValue": "'.round(($review_info['rate_total'] / $review_info['num_reviews'] ),1, PHP_ROUND_HALF_UP).'",'
	    	.'		"bestRating": "5",'
	    	.'		"reviewCount": "'.$review_info['num_reviews'].'"'
	    	.'	}';
	    	$review = $em->getRepository('AppBundle\Entity\Review\Item\Item')->getBestReview();
	    	$snipped .= ', '
	    	.'	"review": {'
	    	.'		"@type": "Review",'
	    	.'		"reviewRating": {'
	    	.'			"@type": "Rating",'
	    	.'			"ratingValue": "'.$review->getRateTotal().'"'
	    	.'		},'
	    	.'		"name": "'.$review->getTitle().'",'
	    	.'		"datePublished": "'.$review->getJobDoneDateFormat().'",'
	    	.'		"reviewBody": "'.$review->getJobDescription().'"';

	    	if(!is_null($review->getAuthorName()))
	    	{
	    		$snipped .= ','
	    				.'		"author": {'
	    				.'		"@type": "Person",'
	    				.'		"name": "'.$review->getAuthorName().'"'
	    			    .'		}';
	    	} else {
	    		$snipped .= ','
	    				.'		"author": {'
	    				.'		"@type": "Person",'
	    				.'		"name": "unknown"'
	    			    .'		}';

	    	}
	    	if(!is_null($review->getExpertTradesReviewId()))
	    	{
		    	$snipped .= ','
		    	.'		"publisher": {'
		    	.'		"@type": "Organization",'
		    	.'		"name": "Expert Trades",'
		    	.'		"url": "https://experttrades.com"'
		    	.'		}';
    		}
	    	$snipped .= '}';
    	}
    	$snipped .= '}';
    	$snipped .= '</script>';
    	return $snipped;

    }

    public function richSnippedReviewJson($em, Request $request, $review_id ){

    	$review_info = $em->getRepository('AppBundle\Entity\Review\Item\Item')->getInfoReview();
    	$snipped = '<script type="application/ld+json">'
    			.'{';
    			if(isset($review_info['num_reviews']) &&  $review_info['num_reviews'] > 0)
    			{
    						$review = $em->getRepository('AppBundle\Entity\Review\Item\Item')->getReview($review_id);
    						$snipped .= ''
    								.'		"@type": "Review",'
    								.'		"reviewRating": {'
    								.'			"@type": "Rating",'
    								.'			"ratingValue": "'.$review->getRateTotal().'"'
    								.'		},'
    								.'		"name": "'.$review->getTitle().'",'
    								.'		"datePublished": "'.$review->getJobDoneDateFormat().'",'
    								.'		"reviewBody": "'.$review->getJobDescription().'"';
    								if(!is_null($review->getAuthorName()))
    								{
    									$snipped .= ','
    									.'		"author": {'
    									.'		"@type": "Person",'
    									.'		"name": "'.$review->getAuthorName().'"'
    									.'		}';
    								} else {
    									$snipped .= ','
    									.'		"author": {'
    									.'		"@type": "Person",'
    									.'		"name": "unknown"'
    									.'		}';

    								}
    								if(!is_null($review->getExpertTradesReviewId()))
    								{
    									$snipped .= ','
    									.'		"publisher": {'
    									.'		"@type": "Organization",'
    									.'		"name": "Expert Trades",'
    									.'		"url": "https://experttrades.com"'
    									.'		}';
    								}
    			}
    	$snipped .= '}';
    	$snipped .= '</script>';
    	return $snipped;
    }

}
