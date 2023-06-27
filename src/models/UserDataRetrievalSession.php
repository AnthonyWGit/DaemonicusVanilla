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
        $stmt = $mySQLconnection->prepare($sqlQuery);                  
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                               
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
        $stmt = $mySQLconnection->prepare($sqlQuery);                 
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                              
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
        $stmt = $mySQLconnection->prepare($sqlQuery);                     
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                                   
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
        $stmt = $mySQLconnection->prepare($sqlQuery);                       
        $stmt->execute();                                                     
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }

    static function startNewCombat();
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'INSERT INTO combat(pv_pkmn1, pv_pkmn2'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                    
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                                 
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }
}