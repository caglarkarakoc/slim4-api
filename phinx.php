<?php

use \Noodlehaus\Config;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

// Env
try {
    $dotenv = Dotenv::create(__DIR__);
    $dotenv->load();
} catch (InvalidPathException $e) {
    die($e);
}

// Load Config
$config = new Config(
    base_path('config/Database.php')
);

return [
    'paths' => [
        'migrations' => $config->get('migrations.paths.migrations'),
        'seeds' => $config->get('migrations.paths.seeds')
    ],
    'migration_base_class' => $config->get('migrations.migration_base_class'),
    'templates' => [
        'file' => $config->get('migrations.templates.file')
    ],
    'environments' => [
        'default_migration_table' => $config->get('migrations.default_migration_table'),
        'default' => [
            'adapter' => $config->get('db.driver'),
            'host' => $config->get('db.host'),
            'name' => $config->get('db.database'),
            'user' => $config->get('db.username'),
            'pass' => $config->get('db.password'),
            'port' => $config->get('db.port'),
            'charset' => $config->get('db.charset'),
            'collation' => $config->get('db.collaction'),
            'unix_socket' => $config->get('db.unix_socket')
        ]
    ]
];
