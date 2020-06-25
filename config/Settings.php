<?php

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, 
            'logger' => [
                'name' => 'app',
                'path' => base_path('var/logs/app.log'),
                'level' => Logger::DEBUG,
            ],
        ],
    ]);
};
