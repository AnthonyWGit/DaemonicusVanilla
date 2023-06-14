<?php
session_start();
//_________________________________AUTOLOAD_____________________________________
spl_autoload_register(function ($class_name)
{
    include 'src\\'.$class_name . '.php';
});


use Controllers\HomepageController;
use Controllers\LoginController;
use Controllers\RegisterController;
use Controllers\DisconnectController;
use Controllers\ForgetPasswordController;

$homepageController = new HomepageController();
$loginController = new LoginController();
$registerController = new RegisterController();
$dcController = new DisconnectController();
$forgotpwdController = new ForgetPasswordController();

if (isset($_GET['action'])) 
{
    switch ($_GET['action'])
        {

            case 'homepage':
                $homepageController->displayHomepage();
                break;
            
            case 'displayLogin':
                $loginController->displayLogin();
                break;
            
            case 'displayRegister':
                $registerController->displayPage();
                break;

            case 'checkInfosRegister':
                $data = $_POST;
                $registerController->checkPostData($data);
                break;

            case 'checkInfosLogin':
                $data = $_POST;               
                $loginController->checkPostData($data);
                break;
            
            case "registerOK":
                $registerController->displaySuccess();
                break;  
            
            case "loginOK":
                $loginController->displaySuccess();
                break;  

            case "disconnect":
                $dcController->disconnect();
                break;
            case "forgotPwd":
                $forgotpwdController->displayPage();
                break;
            case "checkInfosForgotPwd":
                $data = $_POST;
                $forgotpwdController->sendToken($data);
                break;
            case "recoveryOK":
                $forgotpwdController->displayPageOK();
                break;
            case "verifyRecovery":
                $token = $_POST;
                $forgotpwdController->checkRecoveryToken($token);
                break;
            case "changePasswordOK":
                $forgotpwdController->displayPageChangePwd();
                break;
            case "checkNewPwd":
                $newPwd = $_POST["password"];
                $newPwdConfirm = $_POST["password-confirm"];
                $forgotpwdController->checkNewPwd($newPwd, $newPwdConfirm);
                break;
        }
    
}

else
{
    $homepageController->displayHomepage();
}