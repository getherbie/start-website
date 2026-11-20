<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

return static function (
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
): ResponseInterface {
    $response = $handler->handle($request);
    return $response->withHeader('X-Robots-Tag', 'noindex, nofollow');
};
