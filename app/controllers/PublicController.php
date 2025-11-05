<?php

class PublicController{

    public function home() {
        require_once __DIR__ . '/../../views/home.php';
    }

    public function dashboard(){
        AuthMiddleware::handle();
        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

}