<?php

namespace App\Controllers;

// a popo class
class HelloController
{
    public function index($parameters)
    {
        echo view('hello');
    }
}
