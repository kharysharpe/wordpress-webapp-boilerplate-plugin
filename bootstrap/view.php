
<?php

global $wp;

$handler = $wp->query_vars['custom_route']['handler'];
$parameters = $wp->query_vars['custom_route']['vars'];

execute_handler($handler, $parameters);

function execute_handler($handler, $parameters)
{
    if (is_callable($handler)) {
        $handler($parameters);
        return;
    }

    if (method_exists($handler, '__invoke')) {
        (new $handler)->__invoke($parameters);
        return;
    }

    if (strpos($handler, '@') !== false) {
        list($class, $method) = explode('@', $handler);

        (new $class)->$method($parameters);
        return;
    }

    throw new UnexpectedValueException("Invalid route action: [{$handler}].");
}


class get_all_test_handler
{
    public function test($p)
    {
        echo 'Test';
        print_r($p);
    }

    public function test2($p)
    {
        echo 'Test2';
        echo view('test', $p);
    }
}
