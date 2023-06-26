<?php

namespace Models;
use Models\Connect;

class UserDataRetrievalSession
{
    function getProgressionPlayer()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM progression
                    WHERE  id_joueur= :id'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                                     //The data we retrieve are in array form
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }

    static function getPkmnPlayer()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur INNER JOIN pkmn ON pkmn_joueur.id_pkmn = pkmn.id_pkmn
                    WHERE  id_joueur= :id'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                                     //The data we retrieve are in array form
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }

    static function getPkmnPlayerOrderOne()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur INNER JOIN pkmn ON pkmn_joueur.id_pkmn = pkmn.id_pkmn
                    WHERE  id_joueur= :id AND ordre_pkmn = 1'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                                     //The data we retrieve are in array form
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }

    static function setCPUPkmn()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn
                    WHERE  nom_pkm = "Imp"'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->execute();                                                     //The data we retrieve are in array form
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }
}