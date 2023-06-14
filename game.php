<?php
session_start();
//_________________________________AUTOLOAD_____________________________________
spl_autoload_register(function ($class_name)
{
    include 'src\\'.$class_name . '.php';
});


use Controllers\GameController;

$gameController = new GameController();

if (isset($_GET['action'])) 
{
    switch ($_GET['action'])
        {
            case "process":
                $gameController->userHasPkmn();
                break;
        }
}

else
{
    $homepageController->displayHomepage();
}