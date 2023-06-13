<?php

namespace Controllers;

class DisconnectController
{
    public function disconnect()
    {
        // Unset all session variables
        session_unset();

        // Destroy the session
        session_destroy();
        
        header("Location:index.php");
    }
}