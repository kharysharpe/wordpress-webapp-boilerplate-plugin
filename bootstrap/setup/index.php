<?php

// Plugin activation
register_activation_hook(__FILE__, 'webapp_plugin_activation');

function webapp_plugin_activation()
{
    //YOUR CODE
}

// Plugin deactivation
register_deactivation_hook(__FILE__, 'webapp_plugin_deactivation');

function webapp_plugin_deactivation()
{
    //YOUR CODE
}


// Plugin uninstallation
register_uninstall_hook(__FILE__, 'webapp_plugin_uninstall');

function webapp_plugin_uninstall()
{
    // Uninstallation stuff here
}
