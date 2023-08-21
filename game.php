<?php
session_start();

//_________________________________AUTOLOAD_____________________________________
spl_autoload_register(function ($class_name)
{
    include 'src\\'.$class_name . '.php';
});


use Controllers\GameController;
use Controllers\CombatController;

$gameController = new GameController();
$combatController = new CombatController();
if ($_SESSION["session"]) //Session must be set to play the game ; if not redirect to home page 
{
    if (isset($_GET['action'])) 
    {
        switch ($_GET['action'])
            {
                case "process":
                    $gameController->beginnngGame();
                    break;
                case "lvlup":
                    $currentURL = $_SERVER['REQUEST_URI'];
                    $skillParts = explode('/', $currentURL); // Split the string at the '&' symbol
                    $statAndId = explode('_',$skillParts[3]);
                    $_SESSION["lvlUPStat"] = $statAndId[0];
                    $_SESSION["lvlUPId"] = $statAndId[1];
                    break;
            }
    }
    else if (isset($_GET['choice'])) 
    {
        switch ($_GET['choice'])
            {
                case "Hera":
                    $gameController->getHera();
                    break;
                case "AkuAku":
                    $gameController->getAkuAku();
                    break;
                case "Minotor":
                    $gameController->getMinotor();
                    break;
            }
    }
    else if (isset($_GET['combat']))
    {
        switch ($_GET['combat'])
        {
            case "skill":
                $currentURL = $_SERVER['REQUEST_URI'];
                $skillParts = explode('&', $currentURL); // Split the string at the '&' symbol
                $_SESSION["skill"] = $skillParts[1]; //getting the name of skill used 
                $combatController->dmgDealt();
                break;

            default:
                $combatController->startCombat();
                break;
        }
    }
    else if (isset($_GET['Hub']))
    {
        $gameController->beginnngGame();
    }
    else
    {
        header("Location: index.php");
    }    
}
else
{
    header("Location: index.php");
}
