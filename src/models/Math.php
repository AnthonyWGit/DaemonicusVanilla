<?php

namespace Models;
use Models\Connect;
use Models\UserDataRetrievalSession;

class Math
{
    static public function calculateLevel($xp) 
    {
        $baseLevel = 1;
        $maxLevel = 100;

        if ($xp <= 500) 
        {
            return $baseLevel + 1;
        } 
        elseif ($xp <= 30 * 500) 
        {
            $level = $baseLevel + 1;
            $growthFactor = ($xp - 500) / 500 * 0.30 + 1;
            return $level + floor(($xp - 500) / (500 * $growthFactor));
        } 
        elseif ($xp <= 40 * 500) 
        {
            $level = 30 + 1;
            $growthFactor = ($xp - 30 * 500) / (10 * 500) * 0.40 + 1.30;
            return $level + floor(($xp - 30 * 500) / (500 * $growthFactor));
        } 
        elseif ($xp <= 60 * 500) 
        {
            $level = 40 + 1;
            $growthFactor = ($xp - 40 * 500) / (20 * 500) * 0.60 + 1.40;
            return $level + floor(($xp - 40 * 500) / (500 * $growthFactor));
        } 
        elseif ($xp <= 80 * 500) 
        {
            $level = 60 + 1;
            $growthFactor = ($xp - 60 * 500) / (20 * 500) * 0.80 + 1.60;
            return $level + floor(($xp - 60 * 500) / (500 * $growthFactor));
        }
        elseif ($xp <= 100 * 500) 
        {
            $level = 80 + 1;
            $growthFactor = ($xp - 80 * 500) / (20 * 500) * 1 + 1.80;
            return $level + floor(($xp - 80 * 500) / (500 * $growthFactor));
        } 
        else 
        {
            return $maxLevel;
        }
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
}