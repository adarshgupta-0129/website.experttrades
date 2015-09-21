<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Visit\Visit;

class MainController extends Controller
{
    public function trackVisit()
    {
        $em = $this->getDoctrine()->getManager();

        if(!isset($_COOKIE['visit'])) {

            setcookie('visit', '1', time() + 86400, "/");

            $visit = new Visit();
            $visit->setIp();
            $em->persist($visit);
            $em->flush();

        }
    }
}
