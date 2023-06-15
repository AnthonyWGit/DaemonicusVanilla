<?php

namespace Models;

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
}