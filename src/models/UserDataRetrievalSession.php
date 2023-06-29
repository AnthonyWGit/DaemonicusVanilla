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
        
        // SQL request
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM pkmn_joueur WHERE id_joueur = :id_joueur'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->bindValue(":id_joueur", $cpuID2, \PDO::PARAM_INT);
        $stmt->execute(); // Execute the prepared statement
        $CPUIdDaemon = $stmt->fetchAll();
        
        unset($stmt);
        return $CPUIdDaemon;
    }

    static function startNewCombat($maxHPPlayer, $maxHPCPU)
    {

        $firstDeamon = UserDataRetrievalSession::getPkmnPlayerOrderOne();
        UserDataRetrievalSession::generateCPUDaemon();

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

}