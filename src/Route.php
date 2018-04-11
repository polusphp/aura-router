<?php
declare(strict_types=1);

namespace Polus\Router\AuraRouter;

use Polus\Router\RouteInterface;
use Polus\Router\RouterDispatcherInterface;

class Route implements RouteInterface
{
    /** @var \Aura\Router\Route */
    private $route;
    /** @var bool */
    private $failed;
    /** @var string */
    private $method;

    public function __construct(string $method, \Aura\Router\Route $route, bool $failed = false)
    {
        $this->method = $method;
        $this->route = $route;
        $this->failed = $failed;
    }

    public function getStatus(): int
    {
        if ($this->failed) {
            switch ($this->route->failedRule) {
                case 'Aura\Router\Rule\Allows':
                    return RouterDispatcherInterface::METHOD_NOT_ALLOWED;
                case 'Aura\Router\Rule\Accepts':
                    return RouterDispatcherInterface::METHOD_DONT_ACCEPTS;
            }
            return RouterDispatcherInterface::NOT_FOUND;
        }

        return RouterDispatcherInterface::FOUND;
    }

    public function getAllows(): array
    {
        return $this->route->allows;
    }

    public function getHandler()
    {
        return $this->route->handler;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getAttributes(): array
    {
        return $this->route->attributes;
    }
}
