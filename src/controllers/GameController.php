<?php

namespace Controllers;
use Models\Connect;
use Models\UserDataRetrievalSession;

class GameController
{
    // public function userHasPkmn()
    // {
    //     $modelData = new UserDataRetrieval();
    //     $playerId = $modelData->getUserId();
    //     $cleanPlayerId = $playerId[0]["id_joueur"];
    //     $userPkmn = $modelData->getOneRowUser($cleanPlayerId);

    //     if (empty($userPkmn))
    //     {
    //         require_once("views/templates/gameNoDemon.php");
    //     }

    // }

    public function beginnngGame()
    {
        $dataretrievaal = new UserDataRetrievalSession();
        $arrayProg = $dataretrievaal->getProgressionPlayer();
        if ($arrayProg[0]["id_stade_jeu"] == 1 && isset($_SESSION["userID"]))
        {
            require_once("views/templates/gameNoDemon.php");
        }
        else
        {
            echo"Loggin to play the game";
        }
    }
}