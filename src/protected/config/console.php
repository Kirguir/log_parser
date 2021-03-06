<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Log analyzer',

    // preloading 'log' component
    'preload' => array('log'),

    'import' => array(
        'application.components.*',
    ),

    // application components
    'components' => array(

        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),

    ),

    'commandMap' => [
        'import' => [
            'class' => 'application.commands.ImportCommand',
            'path' => '/var/www/log/',
            'pattern' => '/^access[0-9]{0,4}\.log$/i'
        ]
    ]
);
