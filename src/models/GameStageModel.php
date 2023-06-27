<?php

namespace Models;
use Models\Connect;
use Models\UserDataRetrieval;


class GameStageModel
{
    //immediatly used after registration so we can use the username to fiend the newly id. No session because not logged yet
    function initialStage($data)
    {
        $retrieval = new UserDataRetrieval();
        $userID = $retrieval->getUserIdV2($data);
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'INSERT INTO progression 
                    VALUES (:id_joueur, :id_stade_jeu) '; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                     
        $stmt->bindValue(':id_joueur', $userID[0]["id_joueur"]);
        var_dump($userID);
        $stmt->bindValue(':id_stade_jeu', 1);
        $stmt->execute();                                                
        $user = $stmt->fetchAll();
        unset($stmt);
    }

    function setProg($nb)
    {

        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'UPDATE progression
                    SET id_stade_jeu = :id_stade_jeu
                    WHERE id_joueur = :id_joueur '; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->bindValue(':id_joueur', $_SESSION["userID"]);
        $stmt->bindValue(':id_stade_jeu', $nb);
        $stmt->execute();                                                     //The data we retrieve are in array form
        $user = $stmt->fetchAll();
        unset($stmt);
    }

}