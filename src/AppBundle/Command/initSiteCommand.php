<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Homepage\Homepage;
use AppBundle\Entity\Homepage\Slider\Slider;

use AppBundle\Entity\Service\Service;
use AppBundle\Entity\Service\Item\Item as ServiceItem;

use AppBundle\Entity\Review\Review;
use AppBundle\Entity\Review\Item\Item as ReviewItem;

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
          $website->setAccessToken(substr( md5(rand()), 0, 50));
          $em->persist($website);
          $em->flush();

          echo "\nWeb Created \n";
        }

        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);

        if(!is_object($homepage)){
          $homepage = new Homepage();
          $homepage->setAboutUsTitle('ABOUT US');
          $homepage->setAboutUsText('About us text');
          $homepage->setAboutUsFirstPointTitle('Lorem Ipsum is simply dummy text');
          $homepage->setAboutUsFirstPointText('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s');
          $homepage->setAboutUsSecondPointTitle('Lorem Ipsum is simply dummy text');
          $homepage->setAboutUsSecondPointText('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s');
          $homepage->setAboutUsThirdPointTitle('Lorem Ipsum is simply dummy text');
          $homepage->setAboutUsThirdPointText('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s');

          $em->persist($homepage);
          $em->flush();

          for ($i = 1; $i <= 3; $i++) {

              $slider = new Slider();
              $slider->setHomepage($homepage);
              $slider->setTitle('Lorem Ipsum is simply dummy text');
              $slider->setSubtitle('Lorem Ipsum is simply dummy text');
              $slider->setButtonText('Request a Quote');
              $em->persist($slider);
              $em->flush();
          }

          echo "\nHomepage Created \n";
        }

        $service =  $em->getRepository('AppBundle\Entity\Service\Service')->find(1);

        if(!is_object($service)){

          $service = new Service();
          $service->setHeaderText('LOREM IPSUM IS SIMPLY DUMMY TEXT OF THE PRINTING AND TYPESETTING INDUSTRY. LOREM IPSUM HAS BEEN THE INDUSTRY STANDARD DUMMY TEXT EVER SINCE THE 1500S, WHEN AN UNKNOWN PRINTER TOOK A GALLEY OF TYPE AND SCRAMBLED IT TO MAKE A TYPE SPECIMEN BOOK.');
          $service->setHeaderTitle('SERVICES');
          $em->persist($service);
          $em->flush();

          if(sizeof($em->getRepository('AppBundle\Entity\Service\Item\Item')->findAll()) < 6){

              for ($i = 1; $i <= 6; $i++) {
                $item = new ServiceItem();
                $item->setTitle('CEILING FAN REPAIR');
                $item->setSubtitle('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text Lorem Ipsum is simply dummy text of the');
                $em->persist($item);
                $em->flush();
              }
          }

          echo "\n Service Created \n";

        }

        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);

        if(!is_object($review)){

          $review = new Review();
          $review->setHeaderText('LOREM IPSUM IS SIMPLY DUMMY TEXT OF THE PRINTING AND TYPESETTING INDUSTRY. LOREM IPSUM HAS BEEN THE INDUSTRY STANDARD DUMMY TEXT EVER SINCE THE 1500S, WHEN AN UNKNOWN PRINTER TOOK A GALLEY OF TYPE AND SCRAMBLED IT TO MAKE A TYPE SPECIMEN BOOK.');
          $review->setHeaderTitle('SERVICES');
          $em->persist($review);
          $em->flush();

          if(sizeof($em->getRepository('AppBundle\Entity\Review\Item\Item')->findAll()) < 6){

              for ($i = 1; $i <= 6; $i++) {
                  $item = new ReviewItem();
                  $item->setTitle('GREAT WORK DONE BY...');
                  $item->setMessage('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,');
                  $item->setRateTimeManagement(5);
                  $item->setRateFriendly(5);
                  $item->setRateTidiness(5);
                  $item->setRateValue(5);
                  $item->setRateTotal(5);
                  $em->persist($item);
                  $em->flush();
              }
          }

          echo "\n Review Created \n";

        }

        echo "\nSite Created \n";

    }
}
