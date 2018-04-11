<?php
declare(strict_types=1);

namespace Polus\Router\AuraRouter;

use Aura\Router\Map;
use Polus\Router\RouterCollectionInterface;

class RouterCollection implements RouterCollectionInterface
{
    private $map;

    public function __construct(Map $map)
    {
        $this->map = $map;
    }

    public function get(string $route, $handler)
    {
        return $this->map->get(md5($route.'get'), $route, $handler);
    }

    public function put(string $route, $handler)
    {
        return $this->map->put(md5($route.'put'), $route, $handler);
    }

    public function post(string $route, $handler)
    {
        return $this->map->post(md5($route.'post'), $route, $handler);
    }

    public function delete(string $route, $handler)
    {
        return $this->map->delete(md5($route.'delete'), $route, $handler);
    }

    public function patch(string $route, $handler)
    {
        return $this->map->patch(md5($route.'patch'), $route, $handler);
    }

    public function head(string $route, $handler)
    {
        return $this->map->head(md5($route.'head'), $route, $handler);
    }

    public function attach(string $prefix, callable $clb)
    {
        return $this->map->attach(md5($prefix), $prefix, function ($map) use ($clb) {
            $clb(new RouterCollection($map));
        });
    }
}
