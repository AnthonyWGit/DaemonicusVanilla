<?php

namespace Controllers;
use Models\Connect;
use DateTime;

class RegisterController
{
    function displayPage()
    {
        require_once ("views/templates/register.php");
    }

    function displaySuccess()
    {
        require_once("views/templates/registerEnd.php");
    }

    function getUserNames()
    {
        //----------SQL PART-----------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT pseudo_joueur FROM joueur'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->execute();
        $users = $stmt->fetchAll();
    
        //-----------------------------------------
        unset($mySQLconnection);
        return $users;  
    }

    function getEmails()
    {
        //----------SQL PART-----------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'SELECT email_joueur FROM joueur'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->execute();
        $emails = $stmt->fetchAll();
        //-----------------------------------------
        unset($mySQLconnection);
        return $emails;  
    }

    function registerDB($data)
    {
        $newdate = new DateTime();  //inserting date in db
        $newdateFormat = $newdate->format("Y-m-d H:i:s");
        $data['date_creation'] = $newdateFormat;

        //----------SQL PART-----------------------
        $mySQLconnection = Connect::connexion();
        $sqlQuery = 'INSERT INTO joueur (pseudo_joueur, email_joueur, mot_de_passe, date_creation) 
                    VALUES (:username, :email, :password, :date_creation)'; 
        $stmt = $mySQLconnection->prepare($sqlQuery);
        $stmt->execute($data);
        var_dump($stmt);
        unset($mySQLconnection);
        //-----------------------------------------
    }
    
    function checkPostData($data)
    {
        $_SESSION["vide"] = false;
        $permission0 = false;  //Check email DB
        $permissionUsername = false; //check if username is ok
        $permissionPwd = false; 
        $permission2 = false;  //Check if pwd matches confirm pwd
        $permission3 = false;  //check username DB        
        $_SESSION["msg"] ="";
        $pwd ="";
        $listEmails = $this->getEmails();
        $listUsername = $this->getUserNames();

        foreach ($data as $fielname=>$value)
        {
            if (empty($value))
            {
                $_SESSION["vide"] = true;
                break;
            }
        }

        //Case when the db is empty and we want to avoid displaying errors
        if (empty($listEmails))
        {
            $permission0 = true;
            echo "XXXXXXXX";
        }

        if (empty($listUsername))
        {
            $permission3 = true;
            echo "YYYYYYYYY";
        }

        //_________________________________FORM-CHECK______________________________________________
        foreach($data as $field=>$fieldValue)
        {
            switch ($field)
            {

                case "username":
                    if (strlen($fieldValue) > 3 && !preg_match('/[^a-zA-Z0-9]/', $fieldValue && isset($fieldValue)))
                    {
                        $permissionUsername = true;
                        $_SESSION["msg"] .= " username OK";
                    }
                    else
                    {
                        $_SESSION["msg"] .= "Username 3+ chars. No special chars.";                    
                    }
                break;

                case "password": //must have at least one uppercase, one lowercase, one special char, must be set, at least 8 chars
                    //long, must have a numerical
                    if (strlen($fieldValue) >= 8 && preg_match('/[A-Z]/', $fieldValue) && preg_match('/[a-z]/', $fieldValue) 
                    && preg_match('/[0-9]/', $fieldValue) && preg_match('/[^a-zA-Z0-9]/', $fieldValue) && isset($fieldValue))
                    {
                        $permissionPwd = true;
                        $pwd = $fieldValue; //stocking password in value
                    }
                    else 
                    {
                        $_SESSION["msg"] .=     "<p>Password security is terrible.
                                        Choose a password having :</p> 
                                        <ul>
                                            <li>An uppercase</li>
                                            <li>A lowercase</li>
                                            <li>A special char</li>
                                            <li>A number</li>
                                        </ul>
                                        <p>Password must be at least 8 chars long</p>"
                                        ;
                    }
                    break;

                    case "password-confirm": //must be identical as password
                        if (isset($fieldValue) && $fieldValue == $pwd)
                        {
                            $permission2 = true;
                        }
                        else 
                        {
                            $_SESSION["msg"] .= "<p>Passwords are not identical</p>";
                        }
                    break;

                    case "email":
                        if (filter_var($data["email"], FILTER_VALIDATE_EMAIL)) 
                        {
                            $permission0 = true;
                        } 
                        else 
                        {
                            $permission0 = false;
                            $_SESSION["msg"] .= "<li>Emails nope</li>";
                        }
                        break;
            }
        }

        //_____________________EMAIL CHECK________________________________
        foreach ($listEmails as $email)
        {

            if ($email["email_joueur"] == $data["email"])
            {
                $_SESSION["msg"] .= "Email already in use";            //At this point it means that at least on field is incorrect
                $permission0 = false;                           //The previous value in the array could be good so when we land 
                break;                                          //on used emails we go out of loop and permission is still false
            }
            else
            {
                $permission0 = true;
            }
        }
        //_________________________Username Check________________________________

        foreach ($listUsername as $username)
        {

            if ($username["pseudo_joueur"] == $data["username"])
            {
                $_SESSION["msg"] .= "This username is already in use"; //At this point it means that at least on field
                $permission3 = false;
                break;
            }
            else
            {
                $permission3 = true;
            }
        }

        //______________________IF EVERYTHING OK Hash pwd_________________________________

        $options = [
            'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
            'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
            'threads' => PASSWORD_ARGON2_DEFAULT_THREADS,
        ];

        $hashedPwd = password_hash($data["password"], PASSWORD_ARGON2ID, $options);

        //___________________Preparing $data for sql insert : trim non used arrays_______________
        $data["password"] = $hashedPwd;
        unset($data["password-confirm"]);

        //____________________IF EVERYTHING OK SQL INSERT INTO USER DB___________________

        if ($permission0 == true &&
            $permissionUsername == true && $permissionPwd == true && $permission2 == true && $permission3 == true)

        {

            $this->registerDB($data);
            $_SESSION["msg"] = "Register OK";
            //header ("Location:index.php?action=registerOK");
            echo $_SESSION["msg"];
        }
        else
        {
            if ($_SESSION["vide"])
            {
                $_SESSION["msg"] = "You cannot send a form with empty fields";
                echo "test";
            }
           // header("Location:index.php?action=unauthorized");
        }
    }
}
