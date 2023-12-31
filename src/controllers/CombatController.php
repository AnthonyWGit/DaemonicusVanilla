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

   if (isset($_SESSION["playerDaemonCurrentHP"]) && isset($_SESSION["CPUDaemonCurrentHP"]))
   {
      unset($_SESSION["playerDaemonCurrentHP"]);
      unset($_SESSION["CPUDaemonCurrentHP"]);
   }
   else
   {

   }

   $daemon = UserDataRetrievalSession::getPkmnPlayerOrderOne();
   $daemonCPU = UserDataRetrievalSession::setCPUPkmn();
   
   UserDataRetrievalSession::generateCPUDaemon();

   $getStatsPlayer = UserDataRetrievalSession::getPlayerDaemonStats();
   $getStatsCPU = UserDataRetrievalSession::getCPUDaemonStatsFirst();

   $xpDaemonPlayer = $daemon[0]["experience"];
   $xpDaemonCPU = $getStatsCPU[0]["experience"];

   $daemonPlayerLevel = Math::calculateLevel($xpDaemonPlayer);
   $daemonCPULevel = Math::calculateLevel($xpDaemonCPU);
   $statsPlayer = Math::calcStatsPlayer();
   $statsCPU = Math::calcStatsCPU();
   $endPKMN = [];
   $endPKMNCpu = [];
   foreach($statsPlayer as $statDaemon)
   {
      foreach($statDaemon as $stats)
      {
         array_push($endPKMN, $stats["end"]);
      }
   }
   foreach($statsCPU as $statDaemonCpu)
   {
      foreach($statDaemonCpu as $statsCpu)
      {
         array_push($endPKMNCpu, $statsCpu["end"]);
      }
   }
   $daemonCPUMaxHP = Math::CalcMaxHPCPU($endPKMNCpu[0]);
   $daemonPlayerMaxHP = Math::calcMaxHPPlayer($endPKMN[0]);   
   $daemonPlayerCurrentHP = $daemonPlayerMaxHP;
   $daemonCPUCurrentHP = $daemonCPUMaxHP;

   UserDataRetrievalSession::startNewCombat($daemonPlayerMaxHP, $daemonCPUMaxHP);

   $playerOrderOne = UserDataRetrievalSession::getOrderOnePlayer();
   $_SESSION["id_pkmn_joueur"] = $playerOrderOne[0]["id_pkmn_joueur"];



   $firstDaemonAgiPlayer = array_values($statsPlayer[1]);
   $firstDaemonAgiPlayer = $firstDaemonAgiPlayer[0]["agi"];

   $firstDaemonAgiCPU = array_values($statsCPU[1]);
   $firstDaemonAgiCPU = $firstDaemonAgiCPU[0]["agi"];

   if ($firstDaemonAgiPlayer > $firstDaemonAgiCPU)//player pkmn has higher agi
   {
      $initiative = "player";
      $_SESSION["round"] = "player";
   }
   else if ($firstDaemonAgiPlayer < $firstDaemonAgiCPU)
   {
      $initiative = "CPU";
      $_SESSION["round"] = "CPU";
   }
   else //both pkmn have same agi 
   {
      $initiative = (rand(0, 1) === 0) ? "CPU" : "player";
      if ($initiative == "player")
      {
         $_SESSION["round"] = "player";
      }
      else
      {
         $_SESSION["round"] = "CPU";
      }
   }
   
   //loading abilities

   $deamon1ability = UserDataRetrievalSession::getPlayerPkmnAbilities($daemonPlayerLevel);
   $cpuAbilities = UserDataRetrievalSession::getCPUPkmnAbilities($daemonCPULevel);
   $skillNames = $deamon1ability;

   //porting some variables to sessions because we will need them to jump through pages like dmg calc
   $_SESSION["playerDaemonMaxHP"] = $daemonPlayerMaxHP;
   $_SESSION["CPUDaemonMaxHP"] = $daemonCPUMaxHP;
   $_SESSION["playerDaemonCurrentHP"] = $daemonPlayerCurrentHP;
   $_SESSION["CPUDaemonCurrentHP"] = $daemonCPUCurrentHP;
   $_SESSION["PlayerStats"] = $statsPlayer;
   $_SESSION["CPUStats"] = $statsCPU;
   $_SESSION["initiative"] = $initiative;
   $_SESSION["xpEarned"] = 500;
   $daemonCPUPreviousCurrentHP = $_SESSION["CPUDaemonCurrentHP"];
   $daemonPlayerPreviousCurrentHP = $_SESSION["playerDaemonCurrentHP"];

   //json encodes 
   //searching ability names 
   $arrayOfSkills = array_column($deamon1ability, 'nom_compétence');
   $arrayOfSkillsJson = json_encode($arrayOfSkills);

   $arrayOfSkillsCPU = array_column($cpuAbilities, 'nom_compétence');
   $arrayOfSkillsJsonCPU = json_encode($arrayOfSkillsCPU);

   $deamonFirstPlayerStats = array_values($statsPlayer[1]);
   $inArrayStatsCPU = array_values($statsCPU[1]);
   //Need json encore so we can use php var in js code
   $jsonCurrentCPUHp = json_encode($_SESSION["CPUDaemonCurrentHP"]);
   $jsonCurrentPlayerHp = json_encode($_SESSION["playerDaemonCurrentHP"]);
   //js will need max hp data to calculate HP graphic bar
   $jsonMaxCPUHp = json_encode($_SESSION["CPUDaemonMaxHP"]);
   $jsonMaxPlayerHp = json_encode($_SESSION["playerDaemonMaxHP"]);


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

   $skillType = $skillData[0]["type"];

   $statsPlayer = Math::calcStatsPlayer();
   $statsCPU = Math::calcStatsCPU();

   $daemonCPUCurrentHP = $_SESSION["CPUDaemonCurrentHP"];
   $daemonPlayerCurrentHP = $_SESSION["playerDaemonCurrentHP"];

   //These are basically HP of previous turn that will be usefull for animations 
   $daemonCPUPreviousCurrentHP = $_SESSION["CPUDaemonCurrentHP"];
   $daemonPlayerPreviousCurrentHP = $_SESSION["playerDaemonCurrentHP"];

   $deamonFirstPlayerStats = array_values($statsPlayer[1]); //Searching stats for the daemon dealing dmg wich is always first 
   $inArrayStatsCPU = array_values($statsCPU[1]);

   // Get the outermost key (1 in this case)
   $outerKey = array_keys($statsCPU)[0];
   
   // Get the inner array containing "Imp"
   $innerArray = $statsCPU[$outerKey];
   
   // Get the key "Imp" from the inner array
   $keyImp = array_keys($innerArray)[0];
   
   $daemonCPU[0]["nom_pkm"] = $keyImp;

   if ($_SESSION["round"] == "player")
   {
      $dmg = Math::calcDmg($skillPotency, $deamonFirstPlayerStats, $inArrayStatsCPU, $skillType);

         if ($_SESSION["CPUDaemonCurrentHP"] == "" || $_SESSION["playerDaemonCurrentHP"] == "")
         {
            unset($_SESSION["CPUDaemonCurrentHP"]);
            unset($_SESSION["playerDaemonCurrentHP"]);
            header("Location:game.php?Hub");
         }
         else
         {
            $_SESSION["CPUDaemonCurrentHP"] = $daemonCPUCurrentHP - $dmg;
         }
   }
   else
   {
      $dmg = Math::calcDmg($skillPotency, $deamonFirstPlayerStats, $inArrayStatsCPU, $skillType);

      if ($_SESSION["playerDaemonCurrentHP"] == "")
      {
         header("Location:game.php?Hub");
      }
      else
      {
         $_SESSION["playerDaemonCurrentHP"] = $daemonPlayerCurrentHP - $dmg;
      }
   }

   $deamon1ability = UserDataRetrievalSession::getPlayerPkmnAbilities($daemonPlayerLevel);
   $cpuAbilities = UserDataRetrievalSession::getCPUPkmnAbilities($daemonCPULevel);

   $skillNames = $deamon1ability;
   $skillNamesCPU = $cpuAbilities;

   //json encodes
   $arrayOfSkills = array_column($deamon1ability, 'nom_compétence');
   $arrayOfSkillsCPU = array_column($cpuAbilities, 'nom_compétence');

   $arrayOfSkillsJson = json_encode($arrayOfSkills);
   $arrayOfSkillsJsonCPU = json_encode($arrayOfSkillsCPU);

   $jsonCurrentCPUHp = json_encode($_SESSION["CPUDaemonCurrentHP"]);
   $jsonCurrentPlayerHp = json_encode($_SESSION["playerDaemonCurrentHP"]);
   $jsonMaxCPUHp = json_encode($_SESSION["CPUDaemonMaxHP"]);
   $jsonMaxPlayerHp = json_encode($_SESSION["playerDaemonMaxHP"]);

   $jsonPreviousCurrentCPUHp = json_encode($daemonCPUPreviousCurrentHP);
   $jsonPreviousCurrentPlayerHp = json_encode($daemonPlayerPreviousCurrentHP);

   //If CPU is dead
   if ($_SESSION["CPUDaemonCurrentHP"] < 1)
   {
      //Grabbing pkmn lvl in order 1 before level up 
      $daemon = UserDataRetrievalSession::getPkmnPlayerOrderOne();
      $xpDaemonPlayer = $daemon[0]["experience"];
      $daemonPlayerLevelBefore = Math::calculateLevel($xpDaemonPlayer);
      //Adding xp
      UserDataRetrievalSession::lvlUP($_SESSION["xpEarned"], $daemon[0]["id_pkmn_joueur"]);
      //Recalculating level
      $daemon = UserDataRetrievalSession::getPkmnPlayerOrderOne();
      $xpDaemonPlayer = $daemon[0]["experience"];
      $daemonPlayerLevel = Math::calculateLevel($xpDaemonPlayer);
      if ($daemonPlayerLevel != $daemonPlayerLevelBefore)
      {
         UserDataRetrievalSession::capitalPtsUP($daemon[0]["id_pkmn_joueur"]);
      }
      $_SESSION["CPUDaemonCurrentHP"] = "";
   }

   //switching turns from player to CPU
   if ($_SESSION["round"] == "player")
   {
      $_SESSION["round"] = "CPU";
   }
   //switching turns from CPU to player
   else
   {
      ($_SESSION["round"] = "player");
   }

   require_once ("views/templates/gameCombat.php");
 }
}