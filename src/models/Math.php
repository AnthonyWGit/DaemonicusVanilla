<?php

namespace Models;
use Models\Connect;
use Models\UserDataRetrievalSession;

class Math
{
    static public function calculateLevel($xp) 
    {
        $baseLevel = 1;
        $xpNeeded = 500;

        while ($baseLevel <= 30 && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.05);
            $xp = $xp - $xpNeeded;
        }
        while ( ($baseLevel >= 31  && $baseLevel <= 50) && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.075);
            $xp = $xp - $xpNeeded;
        }
        while ( ( $baseLevel >= 51 && $baseLevel <= 90)  && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.1);
            $xp = $xp - $xpNeeded;
        }
        while (($baseLevel  >= 91 && $baseLevel< 100)  && $xp >= $xpNeeded)
        {
            $baseLevel++;

            // Calculate the XP needed for the next level
            $xpNeeded = $xpNeeded + ($xpNeeded * 0.2);
            $xp = $xp - $xpNeeded;
        }

        return $baseLevel;
}

    public static function calcMaxHPPlayer($endPKMN)
    {
        $endPKMNe = UserDataRetrievalSession::getPkmnPlayerOrderOne();
        $daemonHP = 50 + (5 * $endPKMN);
        return $daemonHP;
    }

    public static function calcMaxHPCPU($endPKMNCpu)
    {
        $endPKMN = UserDataRetrievalSession::getPkmnPlayerOrderOne();
        $daemonHP = 50 + (5 * $endPKMNCpu);
        return $daemonHP;
    }    

    public static function calcStatsPlayer()
    {
        $forcePKMNs = UserDataRetrievalSession::getPlayerDaemonStats();
        foreach ($forcePKMNs as $forcePKMN)
        {
            if ($forcePKMN["force_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["force_pkmn"] + $forcePKMN["force_pts"] + ($forcePKMN["force_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["force_pkmn"] + $forcePKMN["force_pts"] - ($forcePKMN["force_pkmn_2"] * 0.1));
            }
            if ($forcePKMN["agi_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["agi"] = floor($forcePKMN["agi_pkmn"] + $forcePKMN["agi_pts"] + ($forcePKMN["agi_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["agi"] = floor($forcePKMN["agi_pkmn"] + $forcePKMN["agi_pts"] - ($forcePKMN["agi_pkmn_2"] * 0.1));
            }
            if ($forcePKMN["end_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["end"] = floor($forcePKMN["end_pkmn"] + $forcePKMN["end_pts"] + ($forcePKMN["end_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["end"] = floor($forcePKMN["end_pkmn"] + $forcePKMN["end_pts"] - ($forcePKMN["end_pkmn_2"] * 0.1)); 
            }
            if ($forcePKMN["int_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["int"] = floor($forcePKMN["int_pkmn"] + $forcePKMN["int_pts"] + ($forcePKMN["int_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["int"] = floor($forcePKMN["int_pkmn"] + $forcePKMN["int_pts"] - ($forcePKMN["int_pkmn_2"] * 0.1));
            }
            if ($forcePKMN["luck_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["luck"] = floor($forcePKMN["luck_pkmn"] + $forcePKMN["luck_pts"] + ($forcePKMN["luck_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["luck"] = floor($forcePKMN["luck_pkmn"] + $forcePKMN["luck_pts"] - ($forcePKMN["luck_pkmn_2"] * 0.1));
            }
            if ($forcePKMN["def_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["def"] = floor($forcePKMN["def_pkmn"] + $forcePKMN["def_pts"] + ($forcePKMN["def_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["def"] = floor($forcePKMN["def_pkmn"] + $forcePKMN["def_pts"] - ($forcePKMN["def_pkmn_2"] * 0.1));
            }

        }
        return $calcFor;
    }

    public static function calcStatsCPU()
    {
        $forcePKMNs = UserDataRetrievalSession::getCPUDaemonStatsFirst();
        foreach ($forcePKMNs as $forcePKMN)
        {
            if ($forcePKMN["force_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["force_pkmn"] + $forcePKMN["force_pts"] + ((1 / 10) * $forcePKMN["force_pkmn_2"]));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["force_pkmn"] + $forcePKMN["force_pts"] - ((1 / 10) * $forcePKMN["force_pkmn_2"]));  
            }
            if ($forcePKMN["agi_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["agi"] = floor($forcePKMN["agi_pkmn"] + $forcePKMN["agi_pts"] + ((1 / 10) * $forcePKMN["agi_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["agi"] = floor($forcePKMN["agi_pkmn"] + $forcePKMN["agi_pts"] - ((1 / 10) * $forcePKMN["agi_pkmn_2"]));  
            }
            if ($forcePKMN["end_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["end"] = floor($forcePKMN["end_pkmn"] + $forcePKMN["end_pts"] + ((1 / 10) * $forcePKMN["end_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["end"] = floor($forcePKMN["end_pkmn"] + $forcePKMN["end_pts"] + ((1 / 10) * $forcePKMN["end_pkmn_2"]));  
            }
            if ($forcePKMN["int_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["int"] = floor($forcePKMN["int_pkmn"] + $forcePKMN["int_pts"] + ((1 / 10) * $forcePKMN["int_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["int"] = floor($forcePKMN["int_pkmn"] + $forcePKMN["int_pts"] - ((1 / 10) * $forcePKMN["int_pkmn_2"]));  
            }
            if ($forcePKMN["luck_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["luck"] = floor($forcePKMN["luck_pkmn"] + $forcePKMN["luck_pts"] + ((1 / 10) * $forcePKMN["luck_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["luck_pkmn"] + $forcePKMN["luck_pts"] - ((1 / 10) * $forcePKMN["luck_pkmn_2"]));  
            }
            if ($forcePKMN["def_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["def"] = floor($forcePKMN["def_pkmn"] + $forcePKMN["def_pts"] + ((1 / 10) * $forcePKMN["def_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["def"] = floor($forcePKMN["def_pkmn"] + $forcePKMN["def_pts"] + ((1 / 10) * $forcePKMN["def_pkmn_2"]));  
            }
        }
        return $calcFor;
    }

    static public function calcDmg($skillPotency, $deamonFirstPlayerStats, $inArrayStatsCPU, $skillType)
    {
        if ($_SESSION["round"] == "player")
        {
            if ($skillType == "phys")
            {
                $dmg = intval(floor(($deamonFirstPlayerStats[0]["for"] + ($skillPotency * 0.1))) * (1 - (0.01 * $inArrayStatsCPU[0]["def"])));
                return $dmg;            
            }
            else if ($skillType == "mag")
            {
                $dmg = intval(floor(($deamonFirstPlayerStats[0]["int"] + ($skillPotency * 0.1))) * (1 - (0.01 * $inArrayStatsCPU[0]["def"])));
                return $dmg;            
            }
            else
            {

            }            
        }
        else
        {
            if ($skillType == "phys")
            {
                $dmg = intval(floor(($inArrayStatsCPU[0]["for"] + ($skillPotency * 0.1))) * (1 - (0.01 * $deamonFirstPlayerStats[0]["def"])));
                return $dmg;            
            }
            else if ($skillType == "mag")
            {
                $dmg = intval(floor(($inArrayStatsCPU[0]["int"] + ($skillPotency * 0.1))) * (1 - (0.01 * $deamonFirstPlayerStats[0]["def"])));
                return $dmg;            
            }
            else
            {

            }     
        }
    }
}