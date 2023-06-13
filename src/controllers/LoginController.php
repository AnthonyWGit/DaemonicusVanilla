<?php

namespace Controllers;
use Models\Connect;

class LoginController
{
    function getOneRowUser($data)
    {
        //------------------------SQL request-----------------------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT * FROM joueur
                    WHERE  pseudo_joueur= :username'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);                        //Prepare, execute, then fetch to retrieve data
        $stmt->bindValue(':username', $data["username"]);
        $stmt->execute();                                                     //The data we retrieve are in array form
        $user = $stmt->fetchAll();
        return $user;
        unset($stmt);
    }

    function displayLogin()
    {
        require_once("views/templates/login.php");
    }

    function displaySuccess()
    {
        var_dump($_SESSION);
        require_once("views/templates/loginEnd.php");
    }

    function checkPostData($data)
    {

        if (isset($_SESSION["session"]))        //Checking if user is already logged in 
        {
            echo "Hm... vous êtes déjà connecté !";
        }

        else
        {
            $_SESSION["msg"] = "";
            $userData = $this->getOneRowUser($data);        //getting the hashed pass from db
            $userExistsDB = false;
            $passwordsMatches = false;

            if (isset($userData[0]["pseudo_joueur"]) && !empty($userData[0]["pseudo_joueur"] && $userData[0]["pseudo_joueur"] == $data["username"]))  //Checking if input user from form exists 
            {
                $userExistsDB = true;
            }
            else
            {
                $_SESSION["msg"] .="<li>Cet utilisateur n'existe pas</li>";
                header("Location:index.php?action=unauthorized");
            }

//Now that we verified that the username exists we verify user pwd imput and hashed pwd from db
            if (isset($userData[0]["mot_de_passe"]) && password_verify($data["password"], $userData[0]["mot_de_passe"]))  
            {
                $passwordsMatches = true;
            } 
            else 
            {
                $_SESSION["msg"] .= "<li>Le mot de passe n'est pas bon.</li>";  //error case
                header("Location:index.php?action=unauthorized");
            }

//We log in when everything is well 
            if ($passwordsMatches && $userExistsDB)
            {
                $_SESSION["msg"] = "Connexion OK";
                $_SESSION['username'] = $data["username"];              //session stuff after require because in the views there is a sesssion start
                $_SESSION["session"] = true; 
                $_SESSION["privilege"] = $userData[0]["role"];
                header("Location:index.php?action=loginOK");
          
            }
            else
            {
                header("Location:index.php?action=unauthorized");
            }
        }
    }
}