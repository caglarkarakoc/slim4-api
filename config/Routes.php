<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


return function (App $app) {
    $app->get('/', 'App\Controllers\DefaultController:help');

    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        
        $group->get('/help', 'App\Controllers\DefaultController:help');
    
        $group->group('/movies', function (RouteCollectorProxy $group) {
    
            // Get All Movies
            $group->get('', 'App\Controllers\MoviesController:index');
    
            // Get One Movie
            $group->get('/{id}', 'App\Controllers\MoviesController:show');
    
            // Create Movie
            $group->post('/create', 'App\Controllers\MoviesController:create');
    
            // Update Movie
            $group->put('/{id}', 'App\Controllers\MoviesController:update');
    
            // Delete Movie
            $group->delete('/{id}', 'App\Controllers\MoviesController:delete');
        });
    });    
};



