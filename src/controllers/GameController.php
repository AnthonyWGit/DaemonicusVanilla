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
            $_SESSION["id_pkmn_joueur"] = []; //Setting anti cheat check
            // var_dump($statsPlayer);
            // var_dump($getStatsPlayer);
            foreach($getStatsPlayer as $key=>$playerData)
            {
                array_push($_SESSION["id_pkmn_joueur"],$playerData["id_pkmn_joueur"]);
                json_encode($playerData["capital_pts"]);
                
                $newValue = $playerData["id_pkmn_joueur"];
                $targetKey = "id_pkmn_joueur";

                foreach ($statsPlayer as &$nestedArray)  //pushing corresponding id of the pkmn into his stats 
                {
                    $nestedArray[key($nestedArray)][$targetKey] = $newValue;
                }
                var_dump($_SESSION);     

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

    public function statUP()
    {
        UserDataRetrievalSession::addStat();
        header("location:game.php?Hub");
    }
}