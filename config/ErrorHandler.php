<?php

use Psr\Http\Message\ServerRequestInterface;

return function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $statusCode = 500;
    if (is_int($exception->getCode()) &&
        $exception->getCode() >= 400 &&
        $exception->getCode() <= 599
    ) {
        $statusCode = $exception->getCode();
    }
    $className = new \ReflectionClass(get_class($exception));
    $data = [
        'message' => $exception->getMessage(),
        'class' => $className->getShortName(),
        'status' => 'error',
        'code' => $statusCode,
    ];
    $body = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    $type = 'application/problem+json';
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write($body);

    return $response->withStatus($statusCode)->withHeader('Content-type', $type);
};