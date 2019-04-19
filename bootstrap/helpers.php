<?php

use eftec\bladeone\BladeOne;

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        $blade = new BladeOne(realpath(WEBAPP_ROOT . '/resources/views'), WEBAPP_ROOT . '/storage/cache/blade', BladeOne::MODE_AUTO);

        $mergedData = [];

        //Automagically add form, errors and messages to all views
        // $mergedData['form']   = get_redirection_data('__form_data', false);
        // $mergedData['errors']     = get_redirection_data('__form_errors', []);
        // $mergedData['messages'] = get_redirection_data('__app_messages', []);


        return (string)$blade->run($view, $data, $mergedData);
    }
}
