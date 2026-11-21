<?php

declare(strict_types=1);

use herbie\middlewares\PageResolverMiddleware;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use startWebsite\ThemeFiles;

require_once dirname(__DIR__) . '/theme_files.php';

return static function (
    ServerRequestInterface $request,
    RequestHandlerInterface $handler,
): ResponseInterface {
    $route = $request->getAttribute(PageResolverMiddleware::HERBIE_REQUEST_ATTRIBUTE_ROUTE, '');
    if (!is_string($route) || !preg_match('~^theme-download/([a-z0-9-]+)$~', $route, $matches)) {
        return $handler->handle($request);
    }

    $theme = $matches[1];
    $siteRoot = dirname(__DIR__, 2);
    $siteData = json_decode((string)@file_get_contents($siteRoot . '/data/site.json'), true);
    $themes = is_array($siteData['themes'] ?? null) ? $siteData['themes'] : [];

    if (!in_array($theme, $themes, true) || !is_dir($siteRoot . '/themes/' . $theme)) {
        return (new Response())->withStatus(404);
    }

    $zip = ThemeFiles::zip(ThemeFiles::collect($siteRoot . '/themes', $theme), $theme);
    $stream = new Stream('php://temp', 'wb+');
    $stream->write($zip);
    $stream->rewind();

    return (new Response())
        ->withHeader('Content-Type', 'application/zip')
        ->withHeader('Content-Disposition', 'attachment; filename="herbie-theme-' . $theme . '.zip"')
        ->withHeader('Content-Length', (string)strlen($zip))
        ->withBody($stream);
};
