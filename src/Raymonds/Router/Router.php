<?php

declare(strict_types=1);

namespace Raymonds\Router;

use Raymonds\Router\Exception\RouterBadMethodCallException;
use Raymonds\Router\Exception\RouterException;
use Raymonds\Router\RouterInterface;

class Router implements RouterInterface
{
    /**
     * array of routes from our routing table
     * @var array
     */
    protected array $routes = [];

    /**
     * Array of route parameters
     * @var array
     */
    protected array $params = [];

    /** 
     * Add a suffix onto the controller name
     * @var string
     */
    protected string $controllerSuffix = 'controller';

    /**
     * @inheritDoc
     */
    public function add(string $route, array $params = []): void
    {
        $this->routes[$route] = $params;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(string $url): void
    {
        if ($this->match($url)) {
            $controllerString = $this->params['controller'];
            $controllerString = $this->CamelCase($controllerString);
            $controllerString = $this->getNamespace($controllerString);

            if (class_exists($controllerString)) {
                $controllerObject = new $controllerString($this->params);
                $action = $this->params['action'];

                if (\is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    throw new RouterBadMethodCallException();
                }
            } else {
                throw new RouterException();
            }
        } else {
            throw new RouterException();
        }
    }

    /**
     * Check if the route passed in the url matches what we have in our routes array
     *
     * @param string $url
     * @return boolean
     */
    private function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $param) {
                    if (is_string($key)) {
                        $params[$key] = $param;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * return a camelized string
     *
     * @param string $string
     * @return string
     */
    public function CamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Get the namespace for the controller class.
     *
     * @param string $string
     * @return string
     */
    public function getNamespace(string $string): string
    {
        $namespace = 'App\Controller\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace . $string;
    }
}
