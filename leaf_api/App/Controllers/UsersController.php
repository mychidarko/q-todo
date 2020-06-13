<?php

namespace App\Controllers;

class AuthController extends Controller {
    public function index() {
        $this->respond([
            "message" => "This is the AuthController"
        ]);
    }
}