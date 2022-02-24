<?php
namespace App\Cloudflare;

use ClientX\App;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TrustMiddleware implements MiddlewareInterface {

    private ContainerInterface $container;
    private App $app;



    public function __construct(ContainerInterface $container, App $app)
    {
        $this->container = $container;
        $this->app       = $app;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->app->moduleIsLoaded(CloudflareModule::class)){
            return $handler->handle($request);
        }
        if ($this->container->get('cloudflare')['enabled'] === 'false'){
            return $handler->handle($request);
        }
        $name = $this->container->get('cloudflare')['forwardedfor'];
        $request = $request->withAddedHeader($name, $request->getHeaderLine('CF-Connecting-IP'));
        if ($request->getUri()->getScheme() === 'HTTPS'){
            $cfVisitorHeader = $request->getHeaderLine('CF-Visitor');
            if ($cfVisitorHeader !== '') {
                $cfVisitor = json_decode($cfVisitorHeader);
                $request = $request->withAddedHeader('X-Forwarded-Proto', $cfVisitor->scheme)->withAddedHeader('X-Forwarded-Port', $cfVisitor->scheme === 'https' ? 443 : 80);
            }
        }
            return $handler->handle($request);
    }

}
