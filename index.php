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

$homepageController = new HomepageController();
$loginController = new LoginController();
$registerController = new RegisterController();
$dcController = new DisconnectController();

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
        }
    
}

else
{
    $homepageController->displayHomepage();
}