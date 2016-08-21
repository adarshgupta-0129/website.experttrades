<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SecurityController extends Controller
{
    public function checkAccess($request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);

        if(in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod')) &&
          $website->getAccessToken() != $request->query->get('access_token')){
          throw new AccessDeniedHttpException();
        }

    }
    public function checkAdminAccess($request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        if(in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod')) &&
          (is_null( $website->getAdminAccessToken() ) || $website->getAdminAccessToken() != $request->query->get('access_token') )){
          throw new AccessDeniedHttpException();
        }

    }

}
