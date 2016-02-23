<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\TeamMember\TeamMember;

class SubscriberController extends SecurityController
{
    /**
     * @Route("/api/v1/subscribers", name="get_subscribers")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();

        $limit = $request->query->get('limit');
        $limit = (is_null($limit)) ? 10 : $limit;

        $offset = $request->query->get('offset');
        $offset = (is_null($offset)) ? 0 : $offset;

        $teamMembers =  $em->getRepository('AppBundle\Entity\Subscriber\Subscriber')
        ->getPaginated($limit, $offset);

        $response = new Response(json_encode($teamMembers));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}
