<?php

declare(strict_types=1);

namespace Raymonds\Router;

interface RouterInterface
{
    /**
     * Add route to the routing array
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function add(string $route, array $params = []): void;


    /**
     * Dispatch route and create controller objects and execute the default method on that controller
     *
     * @param string $url
     */
    public function dispatch(string $url): void;
}
