<?php

namespace App\Controllers;

// an invocable class
class TestController
{
    public function __invoke($parameters)
    {
        echo view('test', $parameters);
    }
}
