<?php

namespace Controllers;
use Models\Connect;
use Models\UserDataRetrievalSession;
use Models\GetFirstDemon;
use Models\GameStageModel;
use Models\Math;

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
        else if ($arrayProg[0]["id_stade_jeu"] > 1 )
        {
            $daemons = $dataretrievaal->getPkmnPlayer();
            $getStatsPlayer = UserDataRetrievalSession::getPlayerDaemonStats();
            $statsPlayer = Math::calcStatsPlayer();
            // var_dump($statsPlayer);
            // var_dump($getStatsPlayer);
            foreach($getStatsPlayer as $truc)
            {
                $_SESSION["id_pkmn_joueurUP".$truc["id_pkmn_joueur"]] = $truc["id_pkmn_joueur"];
                json_encode($truc["capital_pts"]);
                var_dump($daemons);
            }
            require_once("views/templates/gameHub.php");
        }
        else
        {
            echo"Loggin to play the game";
        }
    }

    public function getHera()
    {
        $setStage = new GameStageModel();
        $newChoice = new GetFirstDemon();
        $newChoice->getHeraModel();
        $setStage->setProg(2);

        header("Location:game.php?Hub");

    }
    public function getAkuAku()
    {
        $setStage = new GameStageModel();
        $newChoice = new GetFirstDemon();
        $newChoice->getAkuakuModel();
        $setStage->setProg(2);

        header("Location:game.php?Hub");
    }
    public function getMinotor()
    {
        $setStage = new GameStageModel();
        $newChoice = new GetFirstDemon();
        $newChoice->getMinotorModel();
        $setStage->setProg(2);

        header("Location:game.php?Hub");
    }

    public function displayHub()
    {
        $daemons =  UserDataRetrievalSession::getPkmnPlayer();
        require_once("views/templates/gameHub.php");
    }
}