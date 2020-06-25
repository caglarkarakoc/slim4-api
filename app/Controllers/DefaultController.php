<?php

namespace App\Controllers;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DefaultController extends BaseController
{
    const API_VERSION = '0.0.1';

    /**
     * API help
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function help(Request $request, Response $response) : Response
    {
        return $this->jsonResponse($response, [
            'version' => self::API_VERSION
        ], StatusCodeInterface::STATUS_OK);
    }

    /**
     * Response json
     *
     * @param Response $response
     * @param array $responseContent
     * @param integer $code
     * @return Response
     */
    public function jsonResponse(Response $response, array $responseContent = [], int $code = 200) : Response
    {
        $response->getBody()->write(json_encode($responseContent));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
