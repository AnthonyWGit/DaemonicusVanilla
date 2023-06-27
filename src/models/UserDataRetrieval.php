<?php

namespace Models;
use Models\Connect;

class UserDataRetrieval
{
    function getOneRowUser($userId)
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur
                    WHERE  id_joueur= :id'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->bindValue(':id', $userId);
        $stmt->execute();                                                     //The data we retrieve are in array form
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }

    function getProgressionPlayer()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur
                    WHERE  id_joueur= :id'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->bindValue(':id', $userId);
        $stmt->execute();                                                     //The data we retrieve are in array form
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }
    function getUserId()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT id_joueur FROM joueur
                    WHERE  pseudo_joueur = :username'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->bindValue(':username', $_SESSION["username"]);
        $stmt->execute();                                                     //The data we retrieve are in array form
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }
//the one used at registration without session username
    function getUserIdV2($data)
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT id_joueur FROM joueur
                    WHERE  pseudo_joueur = :username'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);            
        $stmt->bindValue(':username', $data);
        $stmt->execute();                                                
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }
}