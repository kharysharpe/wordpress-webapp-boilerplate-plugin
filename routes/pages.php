<?php

$route->get('/test', 'App\Controllers\HelloController@index');

// id must be a number
$route->get('/test/{id:\d+}', 'App\Controllers\TestController');

$route->get('/test/page', 'App\Controllers\PageController@index');
