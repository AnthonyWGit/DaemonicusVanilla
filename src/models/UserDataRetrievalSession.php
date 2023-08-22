<?php

namespace Models;
use Models\Connect;
use Models\CCC;

class UserDataRetrievalSession
{
    function getProgressionPlayer()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM progression
                    WHERE  id_joueur= :id'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                  
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                               
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }

    static function getPkmnPlayer()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur INNER JOIN pkmn ON pkmn_joueur.id_pkmn = pkmn.id_pkmn
                    WHERE  id_joueur= :id'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                 
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                              
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }

    static function getPkmnPlayerOrderOne()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur INNER JOIN pkmn ON pkmn_joueur.id_pkmn = pkmn.id_pkmn
                    WHERE  id_joueur= :id AND ordre_pkmn = 1'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                     
        $stmt->bindValue(':id', $_SESSION["userID"]);
        $stmt->execute();                                                   
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }

    static function setCPUPkmn()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn
                    WHERE  nom_pkm = "Imp"'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                       
        $stmt->execute();                                                     
        $user = $stmt->fetchAll();
        unset($stmt);
        return $user;
    }

    static function getCPUID()
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM joueur
                    WHERE pseudo_joueur  = "CPU"'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                       
        $stmt->execute();                                                     
        $CPUId = $stmt->fetchAll();
        unset($stmt);
        return $CPUId;
    }

    static function getCPUIDFirstPKmn()
    {
        $cpuID = UserDataRetrievalSession::getCPUID();
        $cpuID2 = $cpuID[0]["id_joueur"];
        
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur WHERE id_joueur = :id_joueur';
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(":id_joueur", $cpuID2, \PDO::PARAM_INT);
        $stmt->execute();
        $CPUIdDaemon = $stmt->fetchAll();
        unset($stmt);
        return $CPUIdDaemon;
    }

    static function startNewCombat($maxHPPlayer, $maxHPCPU)
    {

        $firstDeamon = UserDataRetrievalSession::getPkmnPlayerOrderOne();

        $daemonCPU = UserDataRetrievalSession::getCPUIDFirstPKmn();
        $daemonCPU = $daemonCPU[0]["id_pkmn_joueur"];

        $arrayToExecute = [
            "pv_pkmn_1" => $maxHPPlayer, 
            "pv_pkmn_2" => $maxHPCPU, 
            "id_pkmn_joueur" => $firstDeamon[0]["id_pkmn_joueur"],  
            "id_pkmn_joueur_1" => $daemonCPU];
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'INSERT INTO combat(pv_pkmn_1, pv_pkmn_2, id_pkmn_joueur, id_pkmn_joueur_1)
                    VALUES (:pv_pkmn_1, :pv_pkmn_2, :id_pkmn_joueur, :id_pkmn_joueur_1)'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                 
        $stmt->execute($arrayToExecute);                                             
        unset($stmt);
    }

    static public function generateCPUDaemon()
    {
        $array = [0, 500];
        $randomIndex = array_rand($array);
        $randomValue = $array[$randomIndex];

        $cpuID = UserDataRetrievalSession::getCPUID();

        foreach ($cpuID as $key => $value)
        {
            if ($value["id_joueur"])
            {
                $cpuID2 = ($value["id_joueur"]);
            }
        }

        $ctrl = new CCC();
        $randomCara = $ctrl->pickOneRandomizedCara();

        $arrayToExecute = [
            "experience" => $array[$randomIndex], 
            "id_caractere" => $randomCara, 
            "id_joueur" => $cpuID2, 
            "id_pkmn" => 6];
        $mySQLconnection = Connect::connexion();

        $sqlQuery = 'INSERT INTO pkmn_joueur(experience, id_caractere, id_joueur, id_pkmn) 
                    VALUES (:experience,:id_caractere,:id_joueur, :id_pkmn)'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                    
        $stmt->execute($arrayToExecute);
        $lastInsertID = $mySQLconnection->lastInsertId();
        $_SESSION["id_CPU_daemon"] = $lastInsertID;                                
        unset($stmt);
        return $lastInsertID;             
    }

    static public function getOrderOnePlayer() //id of player of unique so we can use it 
    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur INNER JOIN joueur ON pkmn_joueur.id_joueur = joueur.id_joueur
                    WHERE joueur.id_joueur = :id_joueur
                    AND pkmn_joueur.ordre_pkmn = 1'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(':id_joueur',$_SESSION['userID']);               
        $stmt->execute();          
        $stats = $stmt->fetchAll();
        unset($stmt);
        return $stats;
    }

    static public function getPlayerDaemonStats() //id of player of unique so we can use it 
    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur INNER JOIN joueur ON pkmn_joueur.id_joueur = joueur.id_joueur
                    INNER JOIN pkmn on pkmn_joueur.id_pkmn = pkmn.id_pkmn 
                    INNER JOIN caractere ON pkmn_joueur.id_caractere = caractere.id_caractere
                    WHERE joueur.id_joueur = :id_joueur'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(':id_joueur',$_SESSION['userID']);               
        $stmt->execute();          
        $stats = $stmt->fetchAll();
        unset($stmt);
        return $stats;
    }
    static public function getCPUDaemonStatsFirst() //we can't use cp id because it will show ALL the cpu pkmn
                                                    //Multiple players = theyre will be a lot of entries 

    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur INNER JOIN joueur ON pkmn_joueur.id_joueur = joueur.id_joueur
                    INNER JOIN pkmn on pkmn_joueur.id_pkmn = pkmn.id_pkmn 
                    INNER JOIN caractere ON pkmn_joueur.id_caractere = caractere.id_caractere
                    WHERE pkmn_joueur.id_pkmn_joueur = :id'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(':id',$_SESSION["id_CPU_daemon"]);                       
        $stmt->execute();                                                     
        $stats = $stmt->fetchAll();
        unset($stmt);
        return $stats;
    }

    static public function getPlayerPkmnAbilities($level)
    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM joueur 
        INNER JOIN pkmn_joueur ON pkmn_joueur.id_joueur = joueur.id_joueur
        INNER JOIN pkmn ON pkmn_joueur.id_pkmn = pkmn.id_pkmn
        INNER JOIN apprendre_competence ON apprendre_competence.id_pkmn = pkmn.id_pkmn
        INNER JOIN competence ON apprendre_competence.id_competence = competence.id_competence
        WHERE joueur.id_joueur= :id_joueur AND competence.niveau_comp <= :level '; 
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(':id_joueur',$_SESSION['userID']);
        $stmt->bindValue(':level',$level);           
        $stmt->execute();
        $stats = $stmt->fetchAll();
        unset($stmt);
        return $stats;
    }

    static public function getCPUPkmnAbilities($CPUlevel)
    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM joueur 
        INNER JOIN pkmn_joueur ON pkmn_joueur.id_joueur = joueur.id_joueur
        INNER JOIN pkmn ON pkmn_joueur.id_pkmn = pkmn.id_pkmn
        INNER JOIN apprendre_competence ON apprendre_competence.id_pkmn = pkmn.id_pkmn
        INNER JOIN competence ON apprendre_competence.id_competence = competence.id_competence
        WHERE pkmn_joueur.id_pkmn_joueur = :id_pkmnCPU AND competence.niveau_comp <= :level ';
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(':id_pkmnCPU',$_SESSION["id_CPU_daemon"]);
        $stmt->bindValue(':level',$CPUlevel);           
        $stmt->execute();
        $stats = $stmt->fetchAll();
        unset($stmt);
        return $stats;
    }

    static public function getSkillData()
    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM competence
                    WHERE nom_compétence = :nom_competence';
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(':nom_competence', $_SESSION["skill"]);
        $stmt->execute();
        $skillData= $stmt->fetchAll();
        unset($stmt);
        return $skillData;
    }

    static public function addStat()
    {
        if (in_array($_SESSION["lvlUPId"],$_SESSION["id_pkmn_joueur"])) //Anti cheat check 
        {
            switch ($_SESSION["lvlUPStat"])
            {
                case "for":
                    $mySQLconnection = Connect::connexion();
                    $sqlQuery = 'UPDATE pkmn_joueur
                                SET force_pts = force_pts + 1, capital_pts = capital_pts - 1
                                WHERE id_pkmn_joueur = :id';
                    $stmt = $mySQLconnection->prepare($sqlQuery);
                    $stmt->bindValue(':id', $_SESSION["lvlUPId"]);
                    $stmt->execute();
                    unset($stmt);
                    break;
                case "end":
                    $mySQLconnection = Connect::connexion();
                    $sqlQuery = 'UPDATE pkmn_joueur
                                SET end_pts = end_pts + 1, capital_pts = capital_pts - 1
                                WHERE id_pkmn_joueur = :id';
                    $stmt = $mySQLconnection->prepare($sqlQuery);
                    $stmt->bindValue(':id', $_SESSION["lvlUPId"]);
                    $stmt->execute();
                    unset($stmt);
                    break;
                case "agi":
                    $mySQLconnection = Connect::connexion();
                    $sqlQuery = 'UPDATE pkmn_joueur
                                SET agi_pts = agi_pts + 1, capital_pts = capital_pts - 1
                                WHERE id_pkmn_joueur = :id';
                    $stmt = $mySQLconnection->prepare($sqlQuery);
                    $stmt->bindValue(':id', $_SESSION["lvlUPId"]);
                    $stmt->execute();
                    unset($stmt);
                    break;
                case "int":
                    $mySQLconnection = Connect::connexion();
                    $sqlQuery = 'UPDATE pkmn_joueur
                                SET int_pts = int_pts + 1, capital_pts = capital_pts - 1
                                WHERE id_pkmn_joueur = :id';
                    $stmt = $mySQLconnection->prepare($sqlQuery);
                    $stmt->bindValue(':id', $_SESSION["lvlUPId"]);
                    $stmt->execute();
                    unset($stmt);
                    break;
                case "luck":
                    $mySQLconnection = Connect::connexion();
                    $sqlQuery = 'UPDATE pkmn_joueur
                                SET luck_pts = luck_pts + 1, capital_pts = capital_pts - 1
                                WHERE id_pkmn_joueur = :id';
                    $stmt = $mySQLconnection->prepare($sqlQuery);
                    $stmt->bindValue(':id', $_SESSION["lvlUPId"]);
                    $stmt->execute();
                    unset($stmt);
                    break;
                case "def":
                    $mySQLconnection = Connect::connexion();
                    $sqlQuery = 'UPDATE pkmn_joueur
                                SET def_pts = def_pts + 1, capital_pts = capital_pts - 1
                                WHERE id_pkmn_joueur = :id';
                    $stmt = $mySQLconnection->prepare($sqlQuery);
                    $stmt->bindValue(':id', $_SESSION["lvlUPId"]);
                    $stmt->execute();
                    unset($stmt);
                    break;
            }
        }
        else
        {
            echo "cheating";
        }

    }

    public static function lvlUP($xpEarned, $pkmnToLvl)
    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'UPDATE pkmn_joueur
                    SET experience = experience + :experience
                    WHERE id_pkmn_joueur = :id';
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(':experience', $xpEarned);
        $stmt->bindValue(':id', $pkmnToLvl);
        $stmt->execute();
        unset($stmt);
    }

    public static function capitalPtsUP($pkmnToLvl)
    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'UPDATE pkmn_joueur
                    SET capital_pts = capital_pts + 1
                    WHERE id_pkmn_joueur = :id';
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(':id', $pkmnToLvl);
        $stmt->execute();
        unset($stmt);
    }    
}

