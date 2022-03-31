<?php

declare(strict_types=1);

namespace Whirlwind\Middleware\Uuid;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UuidMiddleware implements MiddlewareInterface
{
    protected ResponseFactoryInterface $responseFactory;

    protected UuidGeneratorInterface $generator;

    protected string $serviceName;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        UuidGeneratorInterface $generator,
        string $serviceName
    ) {
        $this->responseFactory = $responseFactory;
        $this->generator = $generator;
        $this->serviceName = $serviceName;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uuid = $request->getHeaderLine('X-Request-ID');
        $creator = $request->getHeaderLine('X-Request-Creator');
        if (empty($uuid)) {
            $uuid = $this->generator->generate();
            $creator = $this->serviceName;
            $request = $request
                ->withHeader('X-Request-ID', $uuid)
                ->withHeader('X-Request-Creator', $creator);
        }
        $response = $handler->handle($request);
        return $response
            ->withHeader('X-Request-ID', $uuid)
            ->withHeader('X-Request-Creator', $creator)
            ->withHeader('X-Request-Current', $this->serviceName);
    }
}
