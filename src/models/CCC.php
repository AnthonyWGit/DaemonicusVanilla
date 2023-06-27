<?php

namespace Models;
use Models\Connect;

class CCC
{
    function getAllCaracteres()
    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * from caractere';
        $stmt = $mySQLconnection->prepare($sqlQuery);                   
        $stmt->execute();                                                 
        $caracteres = $stmt->fetchAll();
        unset($stmt);
        return $caracteres;        
    }

    function pickOneRandomizedCara()
    {
        $caractereData = $this->getAllCaracteres();
        $idsCara = [];
        foreach ($caractereData as $fieldname=>$value)
        {
            $idsCara[] = $value["id_caractere"];
        }
        $willBeCara = array_rand($idsCara);
        $random = $idsCara[$willBeCara]; //the randomized id 
        return $random;
    }
}