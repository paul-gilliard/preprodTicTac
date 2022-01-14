<?php

namespace App\Model;

use App\Entity\User;

class CreateDBUserModel
{
    public function createDatabaseAlLevel(User $user) {
        // Cette function doit cloner les 3 BDD de références
        // Cette function doit être appeler lors de la création du compte
        // Elle stockera à l'indice de l'utilsiateur sa bdd
         $prefixDatabase = $user->getUserIdentifier();

        //Les trois lignes ci-dessous seront à changer en prod.
        $host    = "127.0.0.1:3306";
        $userDB    = "root";
        $pass    = "";
    
        //Créations BDD "userID+NameDatabase"
        $pdo = new \PDO("mysql:host=$host", $userDB, $pass);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE ". $prefixDatabase."CookingDatabase";
        $pdo->exec($sql);
        $sql = "CREATE DATABASE ". $prefixDatabase."MuseumDatabase";
        $pdo->exec($sql);
        $sql = "CREATE DATABASE ". $prefixDatabase."CompagnyDatabase";
        $pdo->exec($sql);


        
        //clonnage BDD reference
        $pdoUser = $this->connectionUserCookingDatabase($user);
        $cookingSqlExport = file_get_contents("../public/database/cookingreference.sql");
        $pdoUser->exec($cookingSqlExport);

        $pdoUser = $this->connectionUserMuseumDatabase($user);
        $cookingSqlExport = file_get_contents("../public/database/museumreference.sql");
        $pdoUser->exec($cookingSqlExport);

        $pdoUser = $this->connectionUserBusinessDatabase($user);
        $cookingSqlExport = file_get_contents("../public/database/businessreference.sql");
        $pdoUser->exec($cookingSqlExport);
    }

    public function connectionReferenceCookingDatabase(){ // Inutile à l'heure actuelle

        //Les trois lignes ci-dessous seront à changer en prod.
        $host    = "127.0.0.1:3306";
        $userDB    = "root";
        $pass    = "";
        $dbname = "cookingreference";

        $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $userDB, $pass);
        return $pdo;
    }

    public function connectionUserCookingDatabase(User $user){

        //Les trois lignes ci-dessous seront à changer en prod.
        $host    = "127.0.0.1:3306";
        $userDB    = "root";
        $pass    = "";
        $dbname = $user->getCookingDatabaseName();

        $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $userDB, $pass);
        return $pdo;
    }

    public function connectionUserMuseumDatabase(User $user){

        //Les trois lignes ci-dessous seront à changer en prod.
        $host    = "127.0.0.1:3306";
        $userDB    = "root";
        $pass    = "";
        $dbname = $user->getMuseumDatabaseName();

        $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $userDB, $pass);
        return $pdo;
    }

    public function connectionUserBusinessDatabase(User $user){

        //Les trois lignes ci-dessous seront à changer en prod.
        $host    = "127.0.0.1:3306";
        $userDB    = "root";
        $pass    = "";
        $dbname = $user->getCompagnyDatabseName();

        $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $userDB, $pass);
        return $pdo;
    }

}
?>