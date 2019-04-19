<?php

namespace App\Controllers;

// a popo class
class PageController
{
    public function index($parameters)
    {
        echo view('page', $parameters);
    }
}
