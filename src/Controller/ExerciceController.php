<?php

namespace App\Controller;

use App\Entity\QuestionBDDCompagny;
use App\Entity\QuestionBDDCooking;
use App\Entity\QuestionValideeCooking;
use App\Entity\QuestionBDDMuseum;
use App\Entity\QuestionValideeCompagny;
use App\Entity\QuestionValideeMuseum;
use App\Repository\QuestionBDDCookingRepository;
use App\Repository\QuestionBDDMuseumRepository;
use App\Repository\QuestionValideeCookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Form\InputQuestionType;

use App\Entity\User;
use Doctrine\ORM\Mapping\Id;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpFoundation\Request;
use App\Model\ValidatorExerciceModel;
use PDOException;
use Symfony\Component\HttpFoundation\RequestStack;

class ExerciceController extends AbstractController
{
    #[Route('/exercice', name: 'exercice')]
    public function index($numberCurrentQuestionChange="null",Request $request, EntityManagerInterface $manager, RequestStack $requestStack): Response
    {
        // dd($numberCurrentQuestionChange);
        $currentUser = $this->getUser();
        $session = new Session();
        $levelSelect = $session->get('maGlobale');
        $popUp = null;
        $numberWrongResponse = $session->get('numberWrongResponse');
        if($levelSelect == null) {$levelSelect = "levelOne";}

        if ($levelSelect == "levelOne") {
            $difficulte=1;
            if($session->get('countQuestionCooking')==null ){
                $countQuestion = $this->CountQuestion($levelSelect,$session);
            } else {
                $countQuestion = $session->get('countQuestionCooking');
            }

            if($session->get('ValidatedQuestionsCooking')==null){
                $validateQuestion = $this->FindValidateQuestion($levelSelect,$session,$currentUser);
            } else {
                $validateQuestion =$session->get('ValidatedQuestionsCooking');
            }

            
            if($session->get('QuestionsLevelOne')==null){
                $questions = $this->getQuestion($levelSelect,$session);
                $numberCurrentQuestion = 1;
                
                $currentQuestion = $questions[$numberCurrentQuestion-1];
                $session->set('numberCurrentQuestion',$numberCurrentQuestion);
            } else {
                $questions =$session->get('QuestionsLevelOne');
                // dd($questions);
            }
            
            $numberCurrentQuestion =  $session->get('numberCurrentQuestion');
            $currentQuestion=$questions[$numberCurrentQuestion-1];

            // Formulaire de l'input text où l'utilisateur écrit sa question
            $form=$this->createForm(InputQuestionType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $inputText = $data["inputQuestion"];
                $DB = new ValidatorExerciceModel();
                $works=$DB->ValidatorExerciceModel($inputText,$numberCurrentQuestion,$currentUser,$levelSelect,$currentQuestion,$manager);
                if($works instanceof PDOException){
                    // to do Veux-ton qu'une faute de syntaxe soit une erreur ? 
                    //$numberWrongResponse  = $this->oneMoreWrongResponse($session);
                    $popUp = $works->getMessage();
                } else {
                    if($works != "alreadyValidated"){
                        if($works == "validate") {
                            $popUp = "goodAswer";
                            $numberWrongResponse = $this->numberWrongResponseToZero($session);
                        } elseif ($works == "wrong"){
                            $numberWrongResponse  = $this->oneMoreWrongResponse($session);
                            $popUp = "wrongAnswer";
                            
                        }
                        $request=new Request();
                        $this->index("valide",$request,$manager,$requestStack);
                    } else {
                        $popUp = "goodAswerButAlreadyValidate";
                        $numberWrongResponse = $this->numberWrongResponseToZero($session);
                    }
                 }
                $stayInThisQuestion = true;
            } else {
                $stayInThisQuestion = false;
            }

            $stayInThisQuestion=$stayInThisQuestion;

            if($numberCurrentQuestionChange=="null"){
                $numberCurrentQuestion=1;
                $currentQuestion = $questions[$numberCurrentQuestion-1];
            } 
            elseif (($numberCurrentQuestionChange=="précédent" &&  $numberCurrentQuestion > 1) && $stayInThisQuestion == false){
                $numberCurrentQuestion = $session->get('numberCurrentQuestion')-1;
                $session->set('numberCurrentQuestion',$numberCurrentQuestion);
                $currentQuestion = $questions[$numberCurrentQuestion-1];
            } elseif (($numberCurrentQuestionChange=="suivant" &&  $numberCurrentQuestion < $countQuestion) && $stayInThisQuestion == false) {
                
                $numberCurrentQuestion = $session->get('numberCurrentQuestion')+1;
                $session->set('numberCurrentQuestion',$numberCurrentQuestion);
                $currentQuestion = $questions[$numberCurrentQuestion-1];
            }
    

            //Met à vrai ou Faux le disable bouton next/suivant
            if($numberCurrentQuestion == 1){
                $disablePrecedent = "disabled";
                $disableSuivant = "enable";
            } elseif ($numberCurrentQuestion == $countQuestion) {
                $disablePrecedent = "enable";
                $disableSuivant = "disabled";
            } else {
                $disablePrecedent = "enable";
                $disableSuivant = "enable";
            }

            if($numberCurrentQuestionChange=="valide") { //Une question vient d'être validée
                $validateQuestion = $this->FindValidateQuestion($levelSelect,$session,$currentUser); //On re-regarde quels questions sont validées
                $isCurrentQuestionValidate = $this->majIcone($currentQuestion,$validateQuestion);
                
            }
                // isCurrentQuestionValidate est un boolean qui dis si la current question est validée ou non
                $isCurrentQuestionValidate = $this->majIcone($currentQuestion,$validateQuestion);

        } elseif ($levelSelect == "levelTwo") {
            $difficulte=2;
            if($session->get('countQuestionMuseum')==null ){
                $countQuestion = $this->CountQuestion($levelSelect,$session);
            } else {
                $countQuestion = $session->get('countQuestionMuseum');
            }

            if($session->get('ValidatedQuestionsMuseum')==null){
                $validateQuestion = $this->FindValidateQuestion($levelSelect,$session,$currentUser);
            } else {
                $validateQuestion =$session->get('ValidatedQuestionsMuseum');
            }

            
            if($session->get('QuestionsLevelTwo')==null){
                $questions = $this->getQuestion($levelSelect,$session);
                $numberCurrentQuestion = 1;
                $currentQuestion = $questions[$numberCurrentQuestion-1];
                $session->set('numberCurrentQuestion',$numberCurrentQuestion);
            } else {
                $questions =$session->get('QuestionsLevelTwo');
                // dd($questions);
            }
            
            $numberCurrentQuestion =  $session->get('numberCurrentQuestion');
            $currentQuestion=$questions[$numberCurrentQuestion-1];

            // Formulaire de l'input text où l'utilisateur écrit sa question
            $form=$this->createForm(InputQuestionType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $inputText = $data["inputQuestion"];
                $DB = new ValidatorExerciceModel();
                $works=$DB->ValidatorExerciceModel($inputText,$numberCurrentQuestion,$currentUser,$levelSelect,$currentQuestion,$manager);
                if($works instanceof PDOException){
                    // to do Veux-ton qu'une faute de syntaxe soit une erreur ? 
                    //$numberWrongResponse  = $this->oneMoreWrongResponse($session);
                    $popUp = $works->getMessage();
                } else {
                    if($works != "alreadyValidated"){
                        if($works == "validate") {
                            $popUp = "goodAswer";
                            $numberWrongResponse = $this->numberWrongResponseToZero($session);
                        } elseif ($works == "wrong"){
                            $numberWrongResponse  = $this->oneMoreWrongResponse($session);
                            $popUp = "wrongAnswer";
                            
                        }
                        $request=new Request();
                        $this->index("valide",$request,$manager,$requestStack);
                    } else {
                        $popUp = "goodAswerButAlreadyValidate";
                        $numberWrongResponse = $this->numberWrongResponseToZero($session);
                    }
                }
                $stayInThisQuestion = true;
            } else {
                $stayInThisQuestion = false;
            }

            $stayInThisQuestion=$stayInThisQuestion;

            if($numberCurrentQuestionChange=="null"){
                $numberCurrentQuestion=1;
                $currentQuestion = $questions[$numberCurrentQuestion-1];
            } 
            elseif (($numberCurrentQuestionChange=="précédent" &&  $numberCurrentQuestion > 1) && $stayInThisQuestion == false){
                $numberCurrentQuestion = $session->get('numberCurrentQuestion')-1;
                $session->set('numberCurrentQuestion',$numberCurrentQuestion);
                $currentQuestion = $questions[$numberCurrentQuestion-1];
            } elseif (($numberCurrentQuestionChange=="suivant" &&  $numberCurrentQuestion < $countQuestion) && $stayInThisQuestion == false) {
                
                $numberCurrentQuestion = $session->get('numberCurrentQuestion')+1;
                $session->set('numberCurrentQuestion',$numberCurrentQuestion);
                $currentQuestion = $questions[$numberCurrentQuestion-1];
            }
    

            //Met à vrai ou Faux le disable bouton next/suivant
            if($numberCurrentQuestion == 1){
                $disablePrecedent = "disabled";
                $disableSuivant = "enable";
            } elseif ($numberCurrentQuestion == $countQuestion) {
                $disablePrecedent = "enable";
                $disableSuivant = "disabled";
            } else {
                $disablePrecedent = "enable";
                $disableSuivant = "enable";
            }

            if($numberCurrentQuestionChange=="valide") { //Une question vient d'être validée
                $validateQuestion = $this->FindValidateQuestion($levelSelect,$session,$currentUser); //On re-regarde quels questions sont validées
                $isCurrentQuestionValidate = $this->majIcone($currentQuestion,$validateQuestion);
                
            }
                // isCurrentQuestionValidate est un boolean qui dis si la current question est validée ou non
                $isCurrentQuestionValidate = $this->majIcone($currentQuestion,$validateQuestion);
        } elseif ($levelSelect == "levelThree") {
            $difficulte=3;
            if($session->get('countQuestionCompagny')==null ){
                $countQuestion = $this->CountQuestion($levelSelect,$session);
            } else {
                $countQuestion = $session->get('countQuestionCompagny');
            }

            if($session->get('ValidatedQuestionsCompagny')==null){
                $validateQuestion = $this->FindValidateQuestion($levelSelect,$session,$currentUser);
            } else {
                $validateQuestion =$session->get('ValidatedQuestionsCompagny');
            }

            
            if($session->get('QuestionsLevelThree')==null){
                $questions = $this->getQuestion($levelSelect,$session);
                $numberCurrentQuestion = 1;
                $currentQuestion = $questions[$numberCurrentQuestion-1];
                $session->set('numberCurrentQuestion',$numberCurrentQuestion);
            } else {
                $questions =$session->get('QuestionsLevelThree');
                // dd($questions);
            }
            
            $numberCurrentQuestion =  $session->get('numberCurrentQuestion');
            $currentQuestion=$questions[$numberCurrentQuestion-1];

            // Formulaire de l'input text où l'utilisateur écrit sa question
            $form=$this->createForm(InputQuestionType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $inputText = $data["inputQuestion"];
                $DB = new ValidatorExerciceModel();
                $works=$DB->ValidatorExerciceModel($inputText,$numberCurrentQuestion,$currentUser,$levelSelect,$currentQuestion,$manager);
                if($works instanceof PDOException){
                    // to do Veux-ton qu'une faute de syntaxe soit une erreur ? 
                    //$numberWrongResponse  = $this->oneMoreWrongResponse($session);
                    $popUp = $works->getMessage();
                } else {
                    if($works != "alreadyValidated"){
                        if($works == "validate") {
                            $popUp = "goodAswer";
                            $numberWrongResponse = $this->numberWrongResponseToZero($session);
                        } elseif ($works == "wrong"){
                            $numberWrongResponse  = $this->oneMoreWrongResponse($session);
                            $popUp = "wrongAnswer";
                            
                        }
                        $request=new Request();
                        $this->index("valide",$request,$manager,$requestStack);
                    } else {
                        $popUp = "goodAswerButAlreadyValidate";
                        $numberWrongResponse = $this->numberWrongResponseToZero($session);
                    }
                }
                $stayInThisQuestion = true;
            } else {
                $stayInThisQuestion = false;
            }

            $stayInThisQuestion=$stayInThisQuestion;

            if($numberCurrentQuestionChange=="null"){
                $numberCurrentQuestion=1;
                $currentQuestion = $questions[$numberCurrentQuestion-1];
            } 
            elseif (($numberCurrentQuestionChange=="précédent" &&  $numberCurrentQuestion > 1) && $stayInThisQuestion == false){
                $numberCurrentQuestion = $session->get('numberCurrentQuestion')-1;
                $session->set('numberCurrentQuestion',$numberCurrentQuestion);
                $currentQuestion = $questions[$numberCurrentQuestion-1];
            } elseif (($numberCurrentQuestionChange=="suivant" &&  $numberCurrentQuestion < $countQuestion) && $stayInThisQuestion == false) {
                
                $numberCurrentQuestion = $session->get('numberCurrentQuestion')+1;
                $session->set('numberCurrentQuestion',$numberCurrentQuestion);
                $currentQuestion = $questions[$numberCurrentQuestion-1];
            }
    

            //Met à vrai ou Faux le disable bouton next/suivant
            if($numberCurrentQuestion == 1){
                $disablePrecedent = "disabled";
                $disableSuivant = "enable";
            } elseif ($numberCurrentQuestion == $countQuestion) {
                $disablePrecedent = "enable";
                $disableSuivant = "disabled";
            } else {
                $disablePrecedent = "enable";
                $disableSuivant = "enable";
            }

            if($numberCurrentQuestionChange=="valide") { //Une question vient d'être validée
                $validateQuestion = $this->FindValidateQuestion($levelSelect,$session,$currentUser); //On re-regarde quels questions sont validées
                $isCurrentQuestionValidate = $this->majIcone($currentQuestion,$validateQuestion);
                
            }
                // isCurrentQuestionValidate est un boolean qui dis si la current question est validée ou non
                $isCurrentQuestionValidate = $this->majIcone($currentQuestion,$validateQuestion);
        }

    //   dd($popUp);
        return $this->render('exercice/index.html.twig', [
            'controller_name' => 'ExerciceController',
            'niveau' => $levelSelect,
            'countQuestion' => $countQuestion,
            'countValidatedQuestion' => sizeof($validateQuestion),
            'questions' => $questions,
            'currentQuestion' => $currentQuestion,
            'numberCurrentQuestion' => $numberCurrentQuestion,
            'disablePrecedent' => $disablePrecedent,
            'disableSuivant' => $disableSuivant,
            'difficulte'=>$difficulte,
            'isCurrentQuestionValidate'=> $isCurrentQuestionValidate,
            'form' => $form->createView(),
            'numberWrongResponse' => $numberWrongResponse,
            'popUp' => $popUp
        ]);
    }

    //Renvoie le nombre de Question total dans le lecel en cours et l'enregistre en variable globale
    public function CountQuestion($levelSelect,$session){
        if ($levelSelect == "levelOne") {
            $em = $this->getDoctrine()->getManager();
            $locationRepo = $em->getRepository(QuestionBDDCooking::class);
            $result = $locationRepo->countByQuestion();
            $session->set('countQuestionCooking',$result);
            return $result;
        } elseif ($levelSelect == "levelTwo") {
            $em = $this->getDoctrine()->getManager();
            $locationRepo = $em->getRepository(QuestionBDDMuseum::class);
            $result = $locationRepo->countByQuestion();
            $session->set('countQuestionMuseum',$result);
            return $result;
        } elseif ($levelSelect == "levelThree") {
            $em = $this->getDoctrine()->getManager();
            $locationRepo = $em->getRepository(QuestionBDDCompagny::class);
            $result = $locationRepo->countByQuestion();
            $session->set('countQuestionCompagny',$result);
            return $result;
        }
    }   
    //renvoie les questions déjà validés par l'utilisateur connecté et l'enregistre en variable globale
    public function FindValidateQuestion($levelSelect,$session,$currentUser){
        if ($levelSelect == "levelOne") {
            $em = $this->getDoctrine()->getManager();
            $locationRepo = $em->getRepository(QuestionValideeCooking::class);
            // dd($currentUser);    
            $result = $locationRepo->findBy(
                ["idUser" => $currentUser->getUserIdentifier()]
            );
            $session->set('ValidatedQuestionsCooking',$result);
            return $result;
        } elseif ($levelSelect == "levelTwo") {
            $em = $this->getDoctrine()->getManager();
            $locationRepo = $em->getRepository(QuestionValideeMuseum::class);
            // dd($currentUser);    
            $result = $locationRepo->findBy(
                ["idUser" => $currentUser->getUserIdentifier()]
            );
            $session->set('ValidatedQuestionsMuseum',$result);
            return $result;
        } elseif ($levelSelect == "levelThree") {
            $em = $this->getDoctrine()->getManager();
            $locationRepo = $em->getRepository(QuestionValideeCompagny::class);
            // dd($currentUser);    
            $result = $locationRepo->findBy(
                ["idUser" => $currentUser->getUserIdentifier()]
            );
            $session->set('ValidatedQuestionsCompagny',$result);
            return $result;
        }


    }

    public function getQuestion($levelSelect,$session){
        if ($levelSelect == "levelOne") {
            $em = $this->getDoctrine()->getManager();
            $locationRepo = $em->getRepository(QuestionBDDCooking::class);
            
            $result = $locationRepo->findAll();
             $session->set('QuestionsLevelOne',$result);
            // dd($result);
            return $result;
        } elseif ($levelSelect == "levelTwo") {
            $em = $this->getDoctrine()->getManager();
            $locationRepo = $em->getRepository(QuestionBDDMuseum::class);
            $result = $locationRepo->findAll();
            
            $session->set('QuestionsLevelTwo',$result);
            // dd($result);
            // dd($result);
            return $result;
        } elseif ($levelSelect == "levelThree") {
            $em = $this->getDoctrine()->getManager();
            $locationRepo = $em->getRepository(QuestionBDDCompagny::class);
            $result = $locationRepo->findAll();
            
            $session->set('QuestionsLevelThree',$result);
            // dd($result);
            // dd($result);
            return $result;
        }
    }

    
    #[Route('/précédent', name: 'précédent')]
    public function précédent(Request $request, EntityManagerInterface $manager,RequestStack $requestStack){
      return $this->index("précédent",$request,$manager,$requestStack);
    }

    #[Route('/suivant', name: 'suivant')]
    public function suivant(Request $request, EntityManagerInterface $manager,RequestStack $requestStack){
       return $this->index("suivant",$request,$manager,$requestStack);
    }

    #[Route('/exercice/{change}', name: 'exerciceChange')]
    public function changeQuestion(Request $request, EntityManagerInterface $manager, string $change,RequestStack $requestStack){
        return $this->index($change,$request,$manager,$requestStack);
     }

    public function majIcone($currentQuestion,$validateQuestion){
        // isCurrentQuestionValidate est un boolean qui dis si la current question est validée ou non
        $isCurrentQuestionValidate = false;
        for ($i = 0; $i < sizeof($validateQuestion) ; $i++) {
            if($currentQuestion->getId() == $validateQuestion[$i]->getIdQuestionValide()->getId()){
                $isCurrentQuestionValidate = true;
            }
        }
        return  $isCurrentQuestionValidate;
    }

    public function oneMoreWrongResponse($session){
        $numberWrongResponse = $session->get('numberWrongResponse')+1;
        $session->set('numberWrongResponse',$numberWrongResponse);
    }

    public function numberWrongResponseToZero($session){
        $session->set('numberWrongResponse',0);
    }

    public function throwExecption(String $exception,Request $request, EntityManagerInterface $manager,RequestStack $requestStack){
        $session = $requestStack->getSession();
        $session->set('exception',$exception);
        $this->index(null,$request,$manager,$requestStack);
    }
}
