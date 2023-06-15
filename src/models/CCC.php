<?php

namespace Models;
use Models\Connect;

class CCC
{
    function getAllCaracteres()
    {
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * from caractere';
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->execute();                                                     //The data we retrieve are in array form
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