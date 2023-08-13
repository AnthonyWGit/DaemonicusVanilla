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

    public static function calcMaxHPPlayer()
    {
        $endPKMN = UserDataRetrievalSession::getPkmnPlayerOrderOne();
        $endPKMN = $endPKMN[0]["end_pkmn"];
        $daemonHP = 50 + (5 * $endPKMN);
        return $daemonHP;
    }

    public static function calcMaxHPCPU()
    {
        $endPKMN = UserDataRetrievalSession::getPkmnPlayerOrderOne();
        $endPKMN = $endPKMN[0]["end_pkmn"];
        $daemonHP = 50 + (5 * $endPKMN);
        return $daemonHP;
    }    

    public static function calcStatsPlayer()
    {
        $forcePKMNs = UserDataRetrievalSession::getPlayerDaemonStats();
        foreach ($forcePKMNs as $forcePKMN)
        {
            if ($forcePKMN["force_pkmn_2"] < 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["force_pkmn"] + ($forcePKMN["force_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["force_pkmn"] - ($forcePKMN["force_pkmn_2"] * 0.1));
            }
            if ($forcePKMN["agi_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["agi"] = floor($forcePKMN["agi_pkmn"] + ($forcePKMN["agi_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["agi"] = floor($forcePKMN["agi_pkmn"] - ($forcePKMN["agi_pkmn_2"] * 0.1));
            }
            if ($forcePKMN["end_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["end"] = floor($forcePKMN["end_pkmn"] + ($forcePKMN["end_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["end"] = floor($forcePKMN["end_pkmn"] - ($forcePKMN["end_pkmn_2"] * 0.1)); 
            }
            if ($forcePKMN["int_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["int"] = floor($forcePKMN["int_pkmn"] + ($forcePKMN["int_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["int"] = floor($forcePKMN["int_pkmn"] - ($forcePKMN["int_pkmn_2"] * 0.1));
            }
            if ($forcePKMN["luck_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["luck"] = floor($forcePKMN["luck_pkmn"] + ($forcePKMN["luck_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["luck"] = floor($forcePKMN["luck_pkmn"] - ($forcePKMN["luck_pkmn_2"] * 0.1));
            }
            if ($forcePKMN["def_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["def"] = floor($forcePKMN["def_pkmn"] + ($forcePKMN["def_pkmn_2"] * 0.1));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["def"] = floor($forcePKMN["def_pkmn"] - ($forcePKMN["def_pkmn_2"] * 0.1));
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
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["force_pkmn"] + ((1 / 10) * $forcePKMN["force_pkmn_2"]));
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["force_pkmn"] - ((1 / 10) * $forcePKMN["force_pkmn_2"]));  
            }
            if ($forcePKMN["agi_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["agi"] = floor($forcePKMN["agi_pkmn"] + ((1 / 10) * $forcePKMN["agi_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["agi"] = floor($forcePKMN["agi_pkmn"] - ((1 / 10) * $forcePKMN["agi_pkmn_2"]));  
            }
            if ($forcePKMN["end_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["end"] = floor($forcePKMN["end_pkmn"] + ((1 / 10) * $forcePKMN["end_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["end"] = floor($forcePKMN["end_pkmn"] - ((1 / 10) * $forcePKMN["end_pkmn_2"]));  
            }
            if ($forcePKMN["int_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["int"] = floor($forcePKMN["int_pkmn"] + ((1 / 10) * $forcePKMN["int_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["int"] = floor($forcePKMN["int_pkmn"] - ((1 / 10) * $forcePKMN["int_pkmn_2"]));  
            }
            if ($forcePKMN["luck_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["luck"] = floor($forcePKMN["luck_pkmn"] + ((1 / 10) * $forcePKMN["luck_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["for"] = floor($forcePKMN["luck_pkmn"] - ((1 / 10) * $forcePKMN["luck_pkmn_2"]));  
            }
            if ($forcePKMN["def_pkmn_2"] > 0)
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["def"] = floor($forcePKMN["def_pkmn"] + ((1 / 10) * $forcePKMN["def_pkmn_2"]));  
            }
            else
            {
                $calcFor[$forcePKMN["ordre_pkmn"]][$forcePKMN["nom_pkm"]]["def"] = floor($forcePKMN["def_pkmn"] - ((1 / 10) * $forcePKMN["def_pkmn_2"]));  
            }
        }
        return $calcFor;
    }

    static public function calcDmgPhys($skillPotency, $deamonFirstPlayerStats, $inArrayStatsCPU)
    {
        $dmg = intval(floor(($deamonFirstPlayerStats[0]["for"] + ($skillPotency * 0.1))) * (1 - (0.01 * $inArrayStatsCPU[0]["def"])));
        return $dmg;
    }
}