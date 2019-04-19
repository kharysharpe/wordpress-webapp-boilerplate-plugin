<?php
/*
 * Plugin Name: Routing WP
 * Author: Giuseppe Mazzapica
 * Description: A routing system for WordPress
 */
namespace RoutingWP;

class Router
{
    public static $routes = [];

    private function get_current_url()
    {
        $current_url = trim(esc_url_raw(add_query_arg([])), '/');
        $home_path = trim(parse_url(home_url(), PHP_URL_PATH), '/');
        if ($home_path && strpos($current_url, $home_path) === 0) {
            $current_url = trim(substr($current_url, strlen($home_path)), '/');
        }
        return $current_url;
    }

    public static function add($method, $path, $callback, $options)
    {
    }

    public static function get($path, $callback, $options)
    {
        self::add('GET', $path, $callback, $options);
    }

    public static function post($path, $callback, $options)
    {
        self::add('POST', $path, $callback, $options);
    }

    public static function match()
    {
        $allowed = !is_admin() || (defined('DOING_AJAX') && DOING_AJAX);
    }
}



$allowed and add_action('do_parse_request', function ($do_parse, $wp) {
    $routes = [];
    $current_url = get_current_url();
    $routes = apply_filters('routing_add_routes', $routes, $current_url);
    if (empty($routes) || !is_array($routes)) {
        return $do_parse;
    }
    $urlParts = explode('?', $current_url, 2);
    $urlPath = trim($urlParts[0], '/');
    $urlVars = [];
    if (isset($urlParts[1])) {
        parse_str($urlParts[1], $urlVars);
    }
    $query_vars = null;
    foreach ($routes as $pattern => $callback) {
        if (preg_match('~' . trim($pattern, '/') . '~', $urlPath, $matches)) {
            $routeVars = $callback($matches);
            if (is_array($routeVars)) {
                $query_vars = array_merge($routeVars, $urlVars);
                break;
            }
        }
    }
    if (is_array($query_vars)) {
        $wp->query_vars = $query_vars;
        do_action('routing_matched_vars', $query_vars);
        return false;
    }
    return $do_parse;
}, 30, 2);

$allowed and add_action('routing_matched_vars', function () {
    remove_action('template_redirect', 'redirect_canonical');
}, 30);

unset($allowed);
