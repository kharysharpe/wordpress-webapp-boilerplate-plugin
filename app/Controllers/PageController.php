<?php

namespace App\Controllers;

// a popo class
class PageController
{
    public function index($parameters)
    {
        return view('page', $parameters);
    }
}
