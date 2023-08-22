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
        $sqlQuery = 'INSERT INTO pkmn_joueur (id_caractere, id_pkmn, id_joueur, experience, capital_pts) 
                    VALUES (:id_caractere, :id_pkmn, :id_joueur, :experience, :capital_pts)';
        $stmt = $mySQLconnection->prepare($sqlQuery);                  
        $array = [
                    'id_caractere' => $random,
                    'id_joueur' => $_SESSION["userID"],
                    'id_pkmn' => 2,
                    'experience' => 1000,
                    'capital_pts' => 3
                ];
        $stmt->execute($array);                                               
        unset($stmt);
    }

    function getAkuakuModel()
    {
        $ctrl = new CCC();
        $random = $ctrl->pickOneRandomizedCara();
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'INSERT INTO pkmn_joueur (id_caractere, id_pkmn, id_joueur, experience, capital_pts) 
                    VALUES (:id_caractere, :id_pkmn, :id_joueur, :experience, :capital_pts)';
        $stmt = $mySQLconnection->prepare($sqlQuery);                  
        $array = [
                    'id_caractere' => $random,
                    'id_joueur' => $_SESSION["userID"],
                    'id_pkmn' => 3,
                    'experience' => 1000,
                    'capital_pts' => 3
                ];
        $stmt->execute($array);                                               
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
        $stmt = $mySQLconnection->prepare($sqlQuery);                 
        $array = [
                    'id_caractere' => $random,
                    'id_joueur' => $_SESSION["userID"],
                    'id_pkmn' => 5,
                    'experience' => 1000
                ];
        $stmt->execute($array);                                             
        unset($stmt);
    }
}