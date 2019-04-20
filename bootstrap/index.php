<?php

define('WEBAPP_ROOT', realpath(dirname(__FILE__) . '/../'));

include('setup/index.php');


add_action('do_parse_request', function ($do_parse, $wp) {

    // Get current URL minus home path (subfolder installation)
    $current_url = trim(esc_url_raw(add_query_arg([])), '/');

    $home_path = trim(parse_url(home_url(), PHP_URL_PATH), '/');

    if ($home_path && strpos($current_url, $home_path) === 0) {
        $current_url = trim(substr($current_url, strlen($home_path)), '/');
    }

    $current_url = '/' . $current_url;

    $httpMethod = $_SERVER['REQUEST_METHOD'];


    //Detect Route
    $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
        include(WEBAPP_ROOT . '/routes/pages.php');
    });

    $routeInfo = $dispatcher->dispatch($httpMethod, $current_url);

    switch ($routeInfo[0]) {

        case FastRoute\Dispatcher::FOUND:

            $wp->query_vars['custom_route'] = [
                'handler' => $routeInfo[1],
                'parameters' => (array)$routeInfo[2],
            ];

            // $handler = $routeInfo[1];
            // $vars = $routeInfo[2];
            // ... call $handler with $vars

            do_action('custom_routing_matched', $routeInfo);

            return false;

        case FastRoute\Dispatcher::NOT_FOUND:
            // ... 404 Not Found
            break;

        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            // ... 405 Method Not Allowed
            break;
    }

    return $do_parse;
}, 30, 2);

add_action('custom_routing_matched', function ($route) {
    remove_action('template_redirect', 'redirect_canonical');
    add_filter('template_include', 'custom_view_injection', 99);

// add_action('template_include', )
}, 30);


function custom_view_injection($template)
{
    return dirname(__FILE__) . '/view.php';
}
//unset($allowed);


// Setup page routes


// include(WEBAPP_ROOT . '/routes/index.php');
// include(WEBAPP_ROOT . '/routes/index.php');
// include(WEBAPP_ROOT . '/routes/index.php');
