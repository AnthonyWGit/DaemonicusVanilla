<?php

namespace Controllers;
use Models\Connect;

class ForgetPasswordController
{

    public function displayPage()
    {
        require_once("views/templates/forgetPassword.php");
    }

    public function displayPageOK()
    {
        require_once("views/templates/forgetPasswordGoodInfo.php");
    }

    public function displayPageChangePwd()
    {
        if (isset($_SESSION["newPwdInProcess"]) && ($_SESSION["newPwdInProcess"] == 1))
        require_once("views/templates/newPassword.php");
    }

    public function sendToken($dataForm)
    {
        $filter = ["username" => FILTER_SANITIZE_FULL_SPECIAL_CHARS];
        $filteredData = filter_var_array($dataForm, $filter);
        $loginCtrl = new LoginController();
        $userData = $loginCtrl->getOneRowUser($filteredData);
        $bytes = bin2hex(random_bytes(16));
        $to = $userData[0]['email_joueur'];
        $subject = "Token recovery password";
        $message = "This is the recovery token : ".$bytes. " .";
        var_dump($bytes);

        // Additional headers
        $headers = "From: daemonicus@game.com\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8". "\r\n";

        // Send email
        $mailSent = mail($to, $subject, $message, $headers);
        $_SESSION['recovery_token'] = $bytes;

        // Check if email was sent successfully
        if ($mailSent) 
        {
            $_SESSION["tmpEmail"] = $userData[0]['email_joueur'];
            header("Location:index.php?action=recoveryOK");
        } else 
        {
            echo "Failed to send email.";
        }
    }

    public function checkRecoveryToken($token)
    {
        if ($token["recovery"] == $_SESSION["recovery_token"])
        {
            $_SESSION["newPwdInProcess"] = 1;
            header("Location:index.php?action=changePasswordOK");
        }
        else
        {
            echo "fail";
        }
    }

    public function checkNewPwd($newPwd, $newPwdConfirm)
    {
        $permissionPwd = false;

        if ($newPwd == $newPwdConfirm)
        {
            if (strlen($newPwd) >= 8 && preg_match('/[A-Z]/', $newPwd) && preg_match('/[a-z]/', $newPwd) 
            && preg_match('/[0-9]/', $newPwd) && preg_match('/[^a-zA-Z0-9]/', $newPwd) && isset($newPwd))
            {
                $permissionPwd = true;
            }
        
        if ($permissionPwd)
        {
            $options = [
                'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
                'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
                'threads' => PASSWORD_ARGON2_DEFAULT_THREADS,
            ];
    
            $hashedPwd = password_hash($newPwd, PASSWORD_ARGON2ID, $options);


            //----------SQL PART-----------------------
            $mySQLconnection = Connect::connexion();
            $sqlQuery = 'UPDATE joueur
                        SET mot_de_passe = :pwd
                        WHERE email_joueur = :email'; 
            $stmt = $mySQLconnection->prepare($sqlQuery);
            $stmt->bindValue(':pwd',$hashedPwd);
            $stmt->bindValue(':email',$_SESSION["tmpEmail"]);
            $stmt->execute();
            //-----------------------------------------
            unset($mySQLconnection);

            unset($_SESSION["newPwdInProcess"]);
            header("Location:index.php");
        }
   
        }
    }
}