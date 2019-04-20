<?php

global $wp;

$handler = $wp->query_vars['custom_route']['handler'];
$parameters = $wp->query_vars['custom_route']['parameters'];

echo execute_handler($handler, $parameters);

function execute_handler($handler, $parameters)
{
    if (is_array($handler)) {
        $request = $handler;

        if (isset($request['uses'])) {
            $handler = $request['uses'];
        } else {
            $handler = 'Missing uses identifier in route handler.';
        }
    }

    if (is_callable($handler)) {
        return $handler($parameters);
    }

    if (strpos($handler, '@') !== false) {
        list($class, $method) = explode('@', $handler);
        return (new $class)->$method($parameters);
    }

    if (method_exists($handler, '__invoke')) {
        return (new $handler)->__invoke($parameters);
    }

    throw new UnexpectedValueException("Invalid route action: [{$handler}].");
}
