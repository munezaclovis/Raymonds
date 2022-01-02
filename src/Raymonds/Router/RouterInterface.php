<?php

declare(strict_types=1);

namespace Raymonds\Router;

interface RouterInterface
{

    /**
     * Dispatch route and create controller objects and execute the default method on that controller
     *
     * @param string $url
     */
    public function dispatch(): void;
}
