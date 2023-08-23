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
            $_SESSION["id_pkmn_joueurX"] = []; //Setting anti cheat check
            $count = 0;
            $stackCapitalPts["id"] = [];
            $stackCapitalPts["pts"] = [];
            $daemonNames["daemonNames"] = [];
            foreach($getStatsPlayer as $key=>$playerData) //puttin ids of daemons into a session array
            {
                array_push($_SESSION["id_pkmn_joueurX"],$playerData["id_pkmn_joueur"]);
                array_push($stackCapitalPts["id"], $playerData["id_pkmn_joueur"]);
                array_push($stackCapitalPts["pts"], $playerData["capital_pts"]);
                array_push($daemonNames["daemonNames"], $playerData["nom_pkm"]);       
                $newValue[] = $playerData["id_pkmn_joueur"];
                $targetKey = "id_pkmn_joueur";
            }

            $updatedStatsPlayer = array();
            foreach ($statsPlayer as $key => $nestedArray) //Remaking the stats array so view doesn't bug out
            {
                $pokemonName = key($nestedArray);
                $pokemonStats = $nestedArray[$pokemonName];
                $pokemonStats["id_pkmn_joueur"] = $_SESSION["id_pkmn_joueurX"][$count];
                $count = $count+1;
                
                $updatedStatsPlayer[] = [
                    $pokemonName => $pokemonStats
                ];
            }

            $idArray = $stackCapitalPts["id"];
            $ptsArray = $stackCapitalPts["pts"];
            $nameArray = $daemonNames["daemonNames"];

            $combinedArrayCapitalPts = array();
            $combinedDaemonNames = array();

            for ($i = 0; $i < count($idArray); $i++) //Associating index 0 of id with index 0 of capitalPts and so on 
            {
                $id = $idArray[$i];
                $pts = $ptsArray[$i];
                $combinedArrayCapitalPts[$id] = $pts;
            }

            for ($i = 0; $i < count($idArray); $i++) //Associating index 0 of id with index 0 of capitalPts and so on 
            {
                $id = $idArray[$i];
                $name = $nameArray[$i];
                $combinedDaemonNames[$id] = $name;
            }
            // var_dump($statsPlayer);
            // var_dump($combinedArrayCapitalPts);
            var_dump($combinedDaemonNames);
            $jsonCapitalPts = json_encode($combinedArrayCapitalPts);
            $jsonDaemonNames = json_encode($combinedDaemonNames);            
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