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
    $xpDaemonPlayer = $daemon[0]["experience"];

    $daemonCPUMaxHP = 50;
    $daemonPlayerMaxHP = Math::calcMaxHPPlayer();
    $daemonPlayerLevel = Math::calculateLevel($xpDaemonPlayer);

    $daemonPlayerCurrentHP = $daemonPlayerMaxHP;

    $daemonCPUCurrentHP = $daemonCPUMaxHP;

    var_dump($xpDaemonPlayer);
    var_dump($daemonPlayerLevel);
    var_dump($daemonPlayerMaxHP);
    require_once ("views/templates/gameCombat.php");
 }
}