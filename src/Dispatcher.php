<?php
declare(strict_types=1);

namespace Polus\Router\AuraRouter;

use Aura\Router\RouterContainer;
use Polus\Router\RouteInterface;
use Polus\Router\RouterDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dispatcher implements RouterDispatcherInterface
{
    /** @var RouterContainer */
    private $container;

    public function __construct(RouterContainer $container)
    {
        $this->container = $container;
    }

    public function dispatch(ServerRequestInterface $request): RouteInterface
    {
        $matcher = $this->container->getMatcher();
        $route = $matcher->match($request);
        if (!$route) {
            $failedRoute = $matcher->getFailedRoute();
            return new Route($request->getMethod(), $failedRoute, true);
        }

        return new Route($request->getMethod(), $route);
    }
}
