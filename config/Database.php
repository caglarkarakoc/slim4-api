<?php
return [
    'db' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', ''),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'unix_socket' => env('DB_SOCKET', '')
    ],
    'migrations' => [
        'default_migration_table' => 'migrations',
        'migration_base_class' => 'App\Support\Migrations\Migration',
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
        ],
        'templates' => [
            'file' => '%%PHINX_CONFIG_DIR%%/app/Support/Migrations/Migration.stub'
        ]
    ]
];
