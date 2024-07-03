<?php

namespace App\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    protected function json($data){
        echo json_encode($data);
    }
}

