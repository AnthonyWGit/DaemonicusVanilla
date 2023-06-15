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
                $gameController->beginnngGame();
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
else
{
    header("Location: index.php");
}