<?php

namespace Controllers;
use Models\Connect;
use Models\UserDataRetrievalSession;
use Models\GetFirstDemon;
use Models\GameStageModel;
use Models\Math;


class CombatController
{
 public function startCombat()
 {
   $daemon = UserDataRetrievalSession::getPkmnPlayerOrderOne();
   $daemonCPU = UserDataRetrievalSession::setCPUPkmn();
   
   UserDataRetrievalSession::generateCPUDaemon();

   $getStatsPlayer = UserDataRetrievalSession::getPlayerDaemonStats();
   $getStatsCPU = UserDataRetrievalSession::getCPUDaemonStatsFirst();

   $xpDaemonPlayer = $daemon[0]["experience"];
   $xpDaemonCPU = $getStatsCPU[0]["experience"];

   $daemonCPUMaxHP = 50;
   $daemonPlayerMaxHP = Math::calcMaxHPPlayer();

   $daemonPlayerLevel = Math::calculateLevel($xpDaemonPlayer);
   $daemonCPULevel = Math::calculateLevel($xpDaemonCPU);

   $daemonPlayerCurrentHP = $daemonPlayerMaxHP;
   $daemonCPUCurrentHP = $daemonCPUMaxHP;

   UserDataRetrievalSession::startNewCombat($daemonPlayerMaxHP, $daemonCPUMaxHP);

   $playerOrderOne = UserDataRetrievalSession::getOrderOnePlayer();

   $statsPlayer = Math::calcStatsPlayer();
   $statsCPU = Math::calcStatsCPU();

   $firstDaemonAgiPlayer = array_values($statsPlayer[1]);
   $firstDaemonAgiPlayer = $firstDaemonAgiPlayer[0]["agi"];

   $firstDaemonAgiCPU = array_values($statsCPU[1]);
   $firstDaemonAgiCPU = $firstDaemonAgiCPU[0]["agi"];

   if ($firstDaemonAgiPlayer > $firstDaemonAgiCPU)//player pkmn has higher agi
   {
      $initiative = "player";
   }
   else if ($firstDaemonAgiPlayer < $firstDaemonAgiCPU)
   {
      $initiative = "CPU";
   }
   else //both pkmn have same agi 
   {
      $initiative = (rand(0, 1) === 0) ? "CPU" : "player";
   }
   
   //loading abilities

   $deamon1ability = UserDataRetrievalSession::getPlayerPkmnAbilities($daemonPlayerLevel);
   $skillNames = $deamon1ability;
   // var_dump($skillNames);

   //searching ability names 
   $arrayOfSkills = array_column($deamon1ability, 'nom_compétence');
   $arrayOfSkillsJson = json_encode($arrayOfSkills);

 

   // foreach ($nomCompetences as $nom) 
   // {
   //     echo $nom . "<br>";
   // }

   //porting some variables to sessions because we will need them to jump through pages like dmg calc
   $_SESSION["playerDaemonMaxHP"] = $daemonPlayerMaxHP;
   $_SESSION["CPUDaemonMaxHP"] = $daemonCPUMaxHP;
   $_SESSION["playerDaemonCurrentHP"] = $daemonPlayerCurrentHP;
   $_SESSION["CPUDaemonCurrentHP"] = $daemonCPUCurrentHP;
   $_SESSION["PlayerStats"] = $statsPlayer;
   $_SESSION["CPUStats"] = $statsCPU;
   $_SESSION["initiative"] = $initiative;

   $deamonFirstPlayerStats = array_values($statsPlayer[1]);
   $inArrayStatsCPU = array_values($statsCPU[1]);
   // var_dump($inArrayStatsCPU[0]["for"]);
  $jsonCurrentCPUHp = json_encode($_SESSION["CPUDaemonCurrentHP"]);
   require_once ("views/templates/gameCombat.php");
 }

 public function dmgDealt()

 {
   $daemon = UserDataRetrievalSession::getPkmnPlayerOrderOne();

   $getStatsPlayer = UserDataRetrievalSession::getPlayerDaemonStats();
   $getStatsCPU = UserDataRetrievalSession::getCPUDaemonStatsFirst();

   $xpDaemonPlayer = $daemon[0]["experience"];
   $xpDaemonCPU = $getStatsCPU[0]["experience"];

   $daemonPlayerLevel = Math::calculateLevel($xpDaemonPlayer);
   $daemonCPULevel = Math::calculateLevel($xpDaemonCPU);

   $skillData = UserDataRetrievalSession::getSkillData();
   $skillPotency = $skillData[0]["degat_comp"];

   $statsPlayer = Math::calcStatsPlayer();
   $statsCPU = Math::calcStatsCPU();

   $daemonCPUCurrentHP = $_SESSION["CPUDaemonCurrentHP"];

   $deamonFirstPlayerStats = array_values($statsPlayer[1]); //Searching stats for the daemon dealing dmg wich is always first 
   $inArrayStatsCPU = array_values($statsCPU[1]);

   // Get the outermost key (1 in this case)
   $outerKey = array_keys($statsCPU)[0];
   
   // Get the inner array containing "Imp"
   $innerArray = $statsCPU[$outerKey];
   
   // Get the key "Imp" from the inner array
   $keyImp = array_keys($innerArray)[0];
   
   echo $keyImp; // Output: Imp

   $daemonCPU[0]["nom_pkm"] = $keyImp;

   if ($_SESSION["initiative"] == "player")
   {
      $dmg = Math::calcDmgPhys($skillPotency, $deamonFirstPlayerStats, $inArrayStatsCPU);

         if ($_SESSION["CPUDaemonCurrentHP"] == "Dead")
         {
            header("Location:game.php?Hub");
         }
         else
         {
            $_SESSION["CPUDaemonCurrentHP"] = $daemonCPUCurrentHP - $dmg;
            // var_dump($dmg);
            // var_dump($_SESSION["CPUDaemonCurrentHP"]);
         }
   }

   $deamon1ability = UserDataRetrievalSession::getPlayerPkmnAbilities($daemonPlayerLevel);
   $skillNames = $deamon1ability;
   $arrayOfSkills = array_column($deamon1ability, 'nom_compétence');
   $arrayOfSkillsJson = json_encode($arrayOfSkills);
   $jsonCurrentCPUHp = json_encode($_SESSION["CPUDaemonCurrentHP"]);


   //If CPU is dead
   if ($_SESSION["CPUDaemonCurrentHP"] < 1)
   {
      $_SESSION["CPUDaemonCurrentHP"] = "Dead";
   }
   require_once ("views/templates/gameCombat.php");
 }
}