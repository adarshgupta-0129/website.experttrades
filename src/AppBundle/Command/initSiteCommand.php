<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Homepage\Homepage;
use AppBundle\Entity\Homepage\Slider\Slider;

use AppBundle\Entity\AboutUs\AboutUs;

use AppBundle\Entity\Service\Service;
use AppBundle\Entity\Service\Item\Item as ServiceItem;

use AppBundle\Entity\Review\Review;
use AppBundle\Entity\Review\Item\Item as ReviewItem;

use AppBundle\Entity\Gallery\Gallery;
use AppBundle\Entity\Gallery\Item\Item as GalleryItem;

use AppBundle\Entity\Blog\Blog;
use AppBundle\Entity\Blog\Post\Post;
use AppBundle\Entity\Blog\Post\Item\Item as PostItem;

use AppBundle\Entity\Contact\Contact;

use AppBundle\Entity\Website;

class initSiteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('init_site')
             ->setDescription('Init the website');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
	  {

    		$em = $this->getContainer()->get('doctrine')->getManager();
    		$em->getConnection()->getConfiguration()->setSQLLogger(null);

        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);

        if(!is_object($website)){

          $website = new Website();

          $website->setMainColor('#252325');
          $website->setLightColor('#747274');
          $website->setDarkColor('#090709');
          $website->setTradeId(9786);
          $website->setTradeUrl('https://www.experttrades.com/trade/russell-wright-building-and-landscaping');

          $website->setFacebookLink('https://www.facebook.com/localexperttrades?fref=ts');
          $website->setTwitterLink('https://twitter.com/ExpertTradesmen');
          $website->setYoutubeLink('https://www.youtube.com/channel/UCBeI5eUWHMDGovXtqcjKbeg');
          $website->setGoogleLink('https://www.youtube.com/channel/UCBeI5eUWHMDGovXtqcjKbeg');

          $website->setAccessToken(substr( md5(rand()), 0, 50));
          $website->setPostcode('B94AA');
          $website->setCompanyName('Expert Trades');
          $website->setSubscribeTitle('Stay in touch');
          $website->setSubscribeSubtitle('Keep up to date with our special offers');
          $website->setCopyright('©2015 Your Company All rights reserved');
          $em->persist($website);
          $em->flush();

          echo "\nWeb Created. Access Token: ".$website->getAccessToken()." \n";
        }

        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);

        if(!is_object($homepage)){

          $homepage = new Homepage();
          $em->persist($homepage);
          $em->flush();

          $slider = new Slider();
          $slider->setHomepage($homepage);
          $slider->setTitle('QUALIFIED ELECTRICAL SERVICES');
          $slider->setSubtitle('FROM MOVING PLUGS TO HOUSE REWIRES');
          $slider->setButtonText('Request a Quote');
          $slider->setPath('');
          $em->persist($slider);
          $em->flush();

          $slider = new Slider();
          $slider->setHomepage($homepage);
          $slider->setTitle('PLUMBING SERVICES');
          $slider->setSubtitle('HERE TO HELP WITH ALL YOUR PLUMBING NEEDS');
          $slider->setButtonText('Request a Quote');
          $slider->setPath('');
          $em->persist($slider);
          $em->flush();

          $slider = new Slider();
          $slider->setHomepage($homepage);
          $slider->setTitle('BOILER SERVICES');
          $slider->setSubtitle('STAY WARM THIS WINTER. HAVE YOUR BOILER SERVICE');
          $slider->setButtonText('Request a Quote');
          $slider->setPath('');
          $em->persist($slider);
          $em->flush();

          echo "\n Homepage Created \n";
        }

        $aboutUs =  $em->getRepository('AppBundle\Entity\AboutUs\AboutUs')->find(1);

        if(!is_object($aboutUs)){

          $aboutUs = new AboutUs();
          $aboutUs->setHeaderText('WE PRIDE OURSELVES ON OFFERING A HIGH QUALITY SERVICE AND THE BEST PRICE POSSIBLE');
          $aboutUs->setHeaderTitle('ABOUT US');
          $aboutUs->setAboutUsTitle('ABOUT US');
          $aboutUs->setAboutUsText('');
          $aboutUs->setAboutUsFirstPointTitle('Professional');
          $aboutUs->setAboutUsFirstPointText('We provide a friendly, tidy and timely service');
          $aboutUs->setAboutUsFirstPointImage('fa-calendar-o');
          $aboutUs->setAboutUsSecondPointTitle('Fully insured');
          $aboutUs->setAboutUsSecondPointText('We have public liability insurance, ensuring peace of mind for our customers');
          $aboutUs->setAboutUsSecondPointImage('fa-check-circle');
          $aboutUs->setAboutUsThirdPointTitle('Experienced & qualified');
          $aboutUs->setAboutUsThirdPointText('We have all the experience and qualifications needed to provide an excellent service');
          $aboutUs->setAboutUsThirdPointImage('fa-star');

          $aboutUs->setStatisticsTitle('Statistics');

          $aboutUs->setStatisticsFirstBoxNumber('45');
          $aboutUs->setStatisticsFirstBoxText('Positive Reviews');
          $aboutUs->setStatisticsFirstBoxImage('fa-comments');

          $aboutUs->setStatisticsSecondBoxNumber('124');
          $aboutUs->setStatisticsSecondBoxText('Jobs Done So Far');
          $aboutUs->setStatisticsSecondBoxImage('fa-wrench');

          $aboutUs->setStatisticsThirdBoxNumber('12');
          $aboutUs->setStatisticsThirdBoxText('Years Of Expirience');
          $aboutUs->setStatisticsThirdBoxImage('fa-bookmark-o');

          $aboutUs->setStatisticsFourthBoxNumber('5');
          $aboutUs->setStatisticsFourthBoxText('Team Members');
          $aboutUs->setStatisticsFourthBoxImage('fa-smile-o');

          $em->persist($aboutUs);
          $em->flush();

          echo "\n About Us Created \n";
        }

        $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);

        if(!is_object($service)){

          $service = new Service();
          $service->setHeaderText('See below the services we offer');
          $service->setHeaderTitle('SERVICES');
          $em->persist($service);
          $em->flush();

          if(sizeof($em->getRepository('AppBundle\Entity\Service\Item\Item')->findAll()) < 6){

              $item = new ServiceItem();
              $item->setTitle('PLUMBING');
              $item->setSubtitle('Bathroom, Kitchen and WC Plumbing');
              $em->persist($item);
              $em->flush();

          }

          echo "\n Service Created \n";

        }

        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);

        if(!is_object($review)){

          $review = new Review();
          $review->setHeaderText('Recent reviews by our customers');
          $review->setHeaderTitle('REVIEWS');
          $review->setHeaderSubtitle('');
          $em->persist($review);
          $em->flush();
/*
          if(sizeof($em->getRepository('AppBundle\Entity\Review\Item\Item')->findAll()) < 6){

              for ($i = 1; $i <= 3; $i++) {
                  $item = new ReviewItem();
                  $item->setTitle('GREAT WORK DONE BY...');
                  $item->setMessage('Best service ever');
                  $item->setRateTimeManagement(5);
                  $item->setRateFriendly(5);
                  $item->setRateTidiness(5);
                  $item->setRateValue(5);
                  $item->setRateTotal(5);
                  $em->persist($item);
                  $em->flush();
              }
          }
*/
          echo "\n Review Created \n";

        }

        $gallery =  $em->getRepository('AppBundle\Entity\Gallery\Gallery')->find(1);

        if(!is_object($gallery)){

          $gallery = new Gallery();
          $gallery->setHeaderText('WE ARE PROUD OF THE WORK WE DO. WE HAVE INCLUDED SOME EXAMPLES OF OUR WORK BELOW.');
          $gallery->setHeaderTitle('OUR WORK GALLERY');
          $em->persist($gallery);
          $em->flush();

          echo "\n Gallery Created \n";

        }

        $contact =  $em->getRepository('AppBundle\Entity\Contact\Contact')->find(1);

        if(!is_object($contact)){

          $contact = new Contact();
          $contact->setHeaderText('GET IN TOUCH AND WE WILL GET BACK TO YOU AS SOON AS POSSIBLE');
          $contact->setHeaderTitle('CONTACT US');
          $em->persist($contact);
          $em->flush();

          echo "\n Contact Created \n";

        }
        

        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        
        if(!is_object($blog)){
        
        	$blog = new Blog();
        	$blog->setHeaderText('Recent news by ourselves');
        	$blog->setHeaderTitle('BLOG');
        	$blog->setActive(false);
        	$em->persist($blog);
        	$em->flush();
        	echo "\n Blog Created \n";
        
        }

        echo "\n Site Created \n";

    }
}
