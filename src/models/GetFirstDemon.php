<?php

namespace Models;
use Models\Connect;
use Models\CCC;

class GetFirstDemon
{
    function getHeraModel()
    {   //Retrieving all caracteres so we can give a random one 
        $ctrl = new CCC();
        $random = $ctrl->pickOneRandomizedCara();
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'INSERT INTO pkmn_joueur (id_caractere, id_pkmn, id_joueur, experience  ) 
                    VALUES (:id_caractere, :id_pkmn, :id_joueur, :experience)';
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $array = [
                    'id_caractere' => $random,
                    'id_joueur' => $_SESSION["userID"],
                    'id_pkmn' => 2,
                    'experience' => 5000
                ];
        $stmt->execute($array);                                                     //The data we retrieve are in array form
        unset($stmt);
    }

    function getAkuakuModel()
    {
        $ctrl = new CCC();
        $random = $ctrl->pickOneRandomizedCara();
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'INSERT INTO pkmn_joueur (id_caractere, id_pkmn, id_joueur, experience) 
                    VALUES (:id_caractere, :id_pkmn, :id_joueur, :experience)';
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $array = [
                    'id_caractere' => $random,
                    'id_joueur' => $_SESSION["userID"],
                    'id_pkmn' => 3,
                    'experience' => 5000
                ];
        $stmt->execute($array);                                                     //The data we retrieve are in array form
        unset($stmt);
    }

    function getMinotorModel()
    {
        $ctrl = new CCC();
        $random = $ctrl->pickOneRandomizedCara();
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'INSERT INTO pkmn_joueur (id_caractere, id_pkmn, id_joueur, experience) 
                    VALUES (:id_caractere, :id_pkmn, :id_joueur, :experience)';
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $array = [
                    'id_caractere' => $random,
                    'id_joueur' => $_SESSION["userID"],
                    'id_pkmn' => 5,
                    'experience' => 5000
                ];
        $stmt->execute($array);                                                     //The data we retrieve are in array form
        unset($stmt);
    }
}