<?php

namespace Controllers;
use Models\Connect;
use Models\UserDataRetrieval;

class GameController
{
    public function userHasPkmn()
    {
        $modelData = new UserDataRetrieval();
        $playerId = $modelData->getUserId();
        $cleanPlayerId = $playerId[0]["id_joueur"];
        $userPkmn = $modelData->getOneRowUser($cleanPlayerId);

        if (empty($userPkmn))
        {
            require_once("views/templates/gameNoDemon.php");
        }

    }
}