<?php

namespace App\Model;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\QuestionValideeCooking;
use App\Controller\ExerciceController;
use App\Entity\QuestionValideeCompagny;
use App\Entity\QuestionValideeMuseum;

class ValidatorExerciceModel
{
    public function ValidatorExerciceModel($inputUserResponse,$questionNumber,$user,$levelSelect,$currentQuestion, EntityManagerInterface $manager) {
        
        
        try {
            $userRequestResult = $this->getUserResult($levelSelect,$inputUserResponse,$user);
        } catch (\Throwable $th) {
            return $th;
        }
        
        $goodResponse = $this->getGoodResult($questionNumber,$levelSelect,$currentQuestion);
        if($userRequestResult==$goodResponse){ // Or === ? --> Si bonne réponse 

            if($levelSelect=="levelOne"){
                return $this->ifGoodResultCooking($manager,$user,$currentQuestion);
            } elseif($levelSelect=="levelTwo") {
                return  $this->ifGoodResultMuseum($manager,$user,$currentQuestion);
            }

        } else {
            return "wrong";
        }

        //Les trois lignes ci-dessous seront à changer en prod.
        $host    = "127.0.0.1:3306";
        $userDB    = "root";
        $pass    = "";
    
        // //Créations BDD "userID+NameDatabase"
        // $pdo = new \PDO("mysql:host=$host", $userDB, $pass);
        // $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        // $sql = "$inputUserResponse";
        // $result = $pdo->que($sql);

        // return $result;
    }

    public function getUserResult($levelSelect, $inputUserResponse,$user){ // Inutile à l'heure actuelle

        if ($levelSelect == "levelOne") {
            $databaseToIt = $user->getCookingDatabaseName();
        } elseif($levelSelect == "levelTwo") {
            $databaseToIt = $user->getMuseumDatabaseName();
            //Faudra mettre les autres BDD avec elseif elseif else error
        } elseif($levelSelect == "levelThree") {
            $databaseToIt = $user->getCompagnyDatabseName();
        }

       
        // dd($inputUserResponse);
        // dd($databaseToIt);
        //Les trois lignes ci-dessous seront à changer en prod.
        $host    = "127.0.0.1:3306";
        $userDB    = "root";
        $pass    = "";
        $dbname = $databaseToIt;

        $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $userDB, $pass);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $sql = $inputUserResponse;
        $result = $pdo->prepare($sql);
        $result->execute();
        $result = $result->fetchAll();

        return $result;
    }

    public function getGoodResult($questionNumber,$levelSelect,$currentQuestion){

        if ($levelSelect == "levelOne") {
            $databaseToIt = "cookingreference";
        } elseif($levelSelect == "levelTwo") {
            $databaseToIt = "museumreference";
            //Faudra mettre les autres BDD avec elseif elseif else error
        } elseif($levelSelect == "levelThree") {
            $databaseToIt = "compagnyreference";
            //Faudra mettre les autres BDD avec elseif elseif else error
        }

        // dd($inputUserResponse);
        // dd($databaseToIt);
        //Les trois lignes ci-dessous seront à changer en prod.
        $host    = "127.0.0.1:3306";
        $userDB    = "root";
        $pass    = "";
        $dbname = $databaseToIt;


        $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $userDB, $pass);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $sql = $currentQuestion->getReponse();
        $result = $pdo->prepare($sql);
        $result->execute();
        $result = $result->fetchAll();

        return $result;
    }

    public function ifGoodResultCooking($manager,$user,$currentQuestion) {
        $locationRepo = $manager->getRepository(QuestionValideeCooking::class);
            $result = $locationRepo->findBy(
                ["idUser" => $user->getUserIdentifier(),
                "idQuestionValide"=> $currentQuestion->getId()
                ]
            );

            if(sizeof($result)>0){
                return "alreadyValidated";
            }

            $questionValideCooking = new QuestionValideeCooking();
            $questionValideCooking->setIdQuestionValide($currentQuestion);
            $questionValideCooking->setIdUser($user);
            $manager->merge($questionValideCooking);
            $manager->flush();
            return "validate";
    }

    public function ifGoodResultMuseum($manager,$user,$currentQuestion) {
        $locationRepo = $manager->getRepository(QuestionValideeMuseum::class);
            $result = $locationRepo->findBy(
                ["idUser" => $user->getUserIdentifier(),
                "idQuestionValide"=> $currentQuestion->getId()
                ]
            );

            if(sizeof($result)>0){
                return "alreadyValidated";
            }

            $questionValideMuseum = new QuestionValideeMuseum();
            $questionValideMuseum->setIdQuestionValide($currentQuestion);
            $questionValideMuseum->setIdUser($user);
            $manager->merge($questionValideMuseum);
            $manager->flush();
            return "validate";
    }

    public function ifGoodResultCompagny($manager,$user,$currentQuestion) {
        $locationRepo = $manager->getRepository(QuestionValideeCompagny::class);
            $result = $locationRepo->findBy(
                ["idUser" => $user->getUserIdentifier(),
                "idQuestionValide"=> $currentQuestion->getId()
                ]
            );

            if(sizeof($result)>0){
                return "alreadyValidated";
            }

            $questionValideCompagny = new QuestionValideeCompagny();
            $questionValideCompagny->setIdQuestionValide($currentQuestion);
            $questionValideCompagny->setIdUser($user);
            $manager->merge($questionValideCompagny);
            $manager->flush();
            return "validate";
    }

}
?>