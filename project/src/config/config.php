<?php

$test_rt_is_live = false;
$test_rt_is_debug = true;

if (!$test_rt_is_live) {
    return [
        'debug' => $test_rt_is_debug,
        // Database config
        'database' => [
            'driver' => 'pdo_mysql',
            'dbhost' => 'localhost',
            'dbname' => 'sales_test_db',
            'user' => 'root',
            'password' => '***',
            'unix_socket' => '/tmp/mysql.sock',
            'charset' => 'utf8'
        ],
        // Twig config
        'twig' => [
            'path' => realpath(__DIR__ . '/../views')
        ]
    ];
} else {
    return [
        'debug' => $test_rt_is_debug,
        // Database config
        'database' => [
            'host' => '***',
            'dbname' => '***',
            'charset' => 'utf8',
            'user' => '***',
            'password' => '***',
            'driverOptions' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
            )
        ],
        // Twig config
        'twig' => [
            'path' => realpath(__DIR__ . '/../views')
        ]
    ];
}
