<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends MainController
{
    /**
     * @Route("/message-success", name="message_success")
     */
    public function messageSuccessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);
        $blog =  $em->getRepository('AppBundle\Entity\Blog\Blog')->find(1);
        $footerImages =  $em->getRepository('AppBundle\Entity\Gallery\Item\Item')->findBy([],['id' => 'DESC'], 9, 0);

        return $this->render('AppBundle:message:success.html.twig',
        array(
          'website' => $website,
           'hasBlog' => $blog->getActive(),
           'nav_bar_services' => $em->getRepository('AppBundle\Entity\Service\Item\Item')->findBy(['page_active' => true],['id' => 'DESC']),
          'footer_images' => $footerImages,
          'scripts' => $em->getRepository('AppBundle\Entity\Script\Script')->findAll()
        ));
    }
}
