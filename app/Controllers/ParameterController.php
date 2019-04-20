<?php

namespace App\Controllers;

// a popo class
class ParameterController
{
    public function __invoke($parameters)
    {
        return view('parameter', $parameters);
    }
}
