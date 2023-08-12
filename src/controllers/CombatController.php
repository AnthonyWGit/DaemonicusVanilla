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
   var_dump($skillNames);

   //searching ability names 
   $arrayOfSkills = array_column($deamon1ability, 'nom_compétence');
   $arrayOfSkillsJson = json_encode($arrayOfSkills);
   // foreach ($nomCompetences as $nom) 
   // {
   //     echo $nom . "<br>";
   // }

   require_once ("views/templates/gameCombat.php");
 }
}