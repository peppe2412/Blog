<?php

// Rendere le pagine non accessibili per chi non è loggato

class AuthMiddleware{
    
    public static function handle(){

        if(empty($_SESSION['auth_hash'])){
            
            $_SESSION['alert'] = 'Non hai i permessi per accedere alla pagina';
        
            header('Location: /');
            exit;
        }

    }

}
