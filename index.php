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

$homepageController = new HomepageController();
$logginController = new LoginController();
$registerController = new RegisterController();


if (isset($_GET['action'])) 
{
    switch ($_GET['action'])
        {

            case 'homepage':
                $homepageController->displayHomepage();
                break;
            
            case 'displayLogin':
                $logginController->displayLogin();
                break;
            
            case 'displayRegister':
                $registerController->displayPage();
                break;

            case 'checkInfos':
                $data = $_POST;
                var_dump($data);
                $registerController->checkPostData($data);
                break;
        }
    
}

else
{
    $homepageController->displayHomepage();
}