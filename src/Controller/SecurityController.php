<?php

namespace App\Controller;

use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\BrowserKit\Request;
// use Symfony\Component\BrowserKit\Response;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Model\CreateDBUserModel;
use App\Entity\QuestionBDDCooking as q;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route('/inscription', name: 'inscription')]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder)
    {
        $user = new User();
        $form=$this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->hashPassword($user,$user->getPassword());
            $user->setPassword($hash);
            $user-> setRoles("ROLE_USER");
            $manager->persist($user);
            $manager->flush();

            $userId = $user->getId();
            // Par défaut, tout utilisateur a un role "user", on pourra faire ici un test sur l'adresse mail pour avoir un compte avec role admin
            

            $user->setCookingDatabaseName($userId."CookingDatabase");
            $user->setMuseumDatabaseName($userId."MuseumDatabase");
            $user->setCompagnyDatabseName($userId."CompagnyDatabase");
            $manager->persist($user);
            $manager->flush();

            //Création des DB associés à l'utilisateur --> copie avec les exports dans public/database /file.sql
            $DB = new CreateDBUserModel;
            $DB->createDatabaseAlLevel($user);
            
            return $this->redirectToRoute('login');
        }

        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }
        #[Route('/login', name: 'login')]
    public function login()
    {
        return $this->render('security/login.html.twig',[
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(){}

}
