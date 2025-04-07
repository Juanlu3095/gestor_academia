<?php 

namespace src\controllers;

class InicioController {
    
    public static function index() {
        require_once __DIR__ . '/../views/welcome.php';
    }

    public static function users() {
        require_once __DIR__ . '/../views/users.php';
    }
}

?>