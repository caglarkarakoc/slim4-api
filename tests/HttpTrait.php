<?php

namespace App\Test;

use Slim\Psr7\Factory\RequestFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

trait HttpTrait
{
    /**
     * @var App
     */
    protected $app;

    /**
     * App Setup
     *
     * @return void
     */
    protected function setUp() : void
    {
        $this->app = require __DIR__ . '/../bootstrap/App.php';
    }

    /**
     * Create a server request
     *
     * @param string $method
     * @param [type] $uri
     * @return ServerRequestInterface
     */
    protected function createRequest(string $method, $uri): ServerRequestInterface
    {
        $requestFactory = new RequestFactory();
        return $requestFactory->createRequest($method, $uri);
    }

    /**
     * Add Post data
     *
     * @param ServerRequestInterface $request
     * @param array $data
     * @return ServerRequestInterface
     */
    protected function withFormData(ServerRequestInterface $request, array $data): ServerRequestInterface
    {
        if (!empty($data)) {
            $request = $request->withParsedBody($data);
        }

        return $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    /**
     * Add json data
     *
     * @param ServerRequestInterface $request
     * @param array $data
     * @return ServerRequestInterface
     */
    protected function withJson(ServerRequestInterface $request, array $data): ServerRequestInterface
    {
        if (!empty($data)) {
            $request = $request->withParsedBody($data);
        }
        
        return $request->withHeader('Content-Type', 'application/json');
    }

    /**
     * Make request
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    protected function request(ServerRequestInterface $request): ResponseInterface
    {
        return $this->app->handle($request);
    }
}
