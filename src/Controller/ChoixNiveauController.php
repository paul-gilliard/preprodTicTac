<?php

namespace App\Controller;

use App\Entity\ImageNiveau;
use App\Form\ImageNiveauFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class ChoixNiveauController extends AbstractController
{
    #[Route('/choix/niveau', name: 'choix_niveau')]
    public function index(Request $request, RequestStack $requestStack): Response
    {
        if($request->query->count() > 0 ) {
            $recup = $request->query->all();
            $levelSelect=$recup["btnradio1"];
            $session = $requestStack->getSession();
            // $session = new Session();
            
            $session->set('maGlobale',$levelSelect);
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'niveau' => $levelSelect
            ]);
        }
        
        /*$response = new Response();
        $response->headers->setCookie(new Cookie($level,));*/

        return $this->renderForm('choix_niveau/index.html.twig', [
            'controller_name' => 'ChoixNiveauController'
        ]);
    }
}
