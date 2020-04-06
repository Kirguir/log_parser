<?php

// This is the database connection configuration.
return array(
    //'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    // uncomment the following lines to use a MySQL database

    'connectionString' => 'mysql:host=db;dbname=logs',
    'emulatePrepare' => true,
    'username' => 'root',
    'password' => getenv('DATABASE_PASSWORD', true),
    'charset' => 'utf8',

);
