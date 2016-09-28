<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
//        $user = $this->get('security.token_storage')->getToken()->getUser();
//        $username  = $this->getUser()->getUsername();
//
//        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
//            print_r("HERE");die;
//
//        }


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}
