<?php

namespace App\Controllers;

class TodosController extends Controller {
    public function index() {
        $this->respond([
            "message" => "This is the TodosController"
        ]);
    }
}