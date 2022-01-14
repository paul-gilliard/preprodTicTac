<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends AbstractController
{
   

    #[Route('/', name: 'home')]
    public function index(RequestStack $requestStack): Response
    {
        // $session = new Session();
        $session = $requestStack->getSession();
        $levelSelect = $session->get('maGlobale');
        
        if($levelSelect==null){
            $levelSelect="levelOne";
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'niveau'=>$levelSelect
        ]);
    }
}
