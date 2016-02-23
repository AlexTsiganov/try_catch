<?php

return [
    'debug' => true,
    // Database config
    'database' => [
        'driver' => 'pdo_mysql',
        'dbhost' => 'localhost',
        'dbname' => 'sales_test_db',
        'user' => 'root',
        'password' => 'Alex03636',
        'unix_socket' => '/tmp/mysql.sock',
        'charset' => 'utf8'
    ],
    // Twig config
    'twig' => [
        'path' => realpath(__DIR__ . '/../../views')
    ]
];
