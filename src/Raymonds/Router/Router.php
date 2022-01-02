<?php

declare(strict_types=1);

namespace Raymonds\Router;

use Raymonds\GlobalManager\GlobalManager;
use Raymonds\Router\RouterInterface;
use Raymonds\Router\Exception\RouterException;
use Raymonds\Router\Exception\RouterBadMethodCallException;
use Raymonds\Traits\StringTrait;
use Raymonds\Yaml\Config;

class Router implements RouterInterface
{
    use StringTrait;
    /**
     * array of routes from our routing table
     * @var array
     */
    protected array $route = [];

    /**
     * Array of route parameters
     * @var array
     */
    protected array $params = [];

    protected array $url;

    /** 
     * Add a suffix onto the controller name
     * @var string
     */
    protected string $controllerSuffix = 'controller';

    public function __construct()
    {
        $this->setUrl();
        $this->setController();
        $this->setAction();
        $this->setParams();
    }

    /**
     * @inheritDoc
     */
    public function dispatch(): void
    {
        $controllerString = $this->route['controller'];
        $controllerString = $this->CamelCase($controllerString);
        $controllerClass = $this->getNamespace($controllerString);

        if (class_exists($controllerClass)) {
            $controllerObject = new $controllerClass($this->route);

            if (\is_callable([$controllerObject, $this->route['action']])) {
                call_user_func_array([$controllerObject, $this->route['action']], $this->params);
            } else {
                throw new RouterBadMethodCallException('Page not found', 404);
            }
        } else {
            throw new RouterException('Page not found', 404);
        }
    }

    public function setController()
    {
        $this->route['controller'] = $this->url[0] ?? Config::file('app')['defaults']['controller'] ?? "home";
        array_shift($this->url);
    }
    public function setAction()
    {
        $this->route['action'] = $this->url[0] ?? Config::file('app')['defaults']['action'] ?? "index";
        array_shift($this->url);
    }

    public function setParams()
    {
        $this->params = $this->url ?? [];
        unset($this->url);
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
        return $namespace . $string . $this->CamelCase($this->controllerSuffix);
    }

    public function setUrl()
    {
        $url = mb_strtolower(GlobalManager::get('_SERVER')['REQUEST_URI']);
        $scriptName = mb_strtolower(GlobalManager::get('_SERVER')['SCRIPT_NAME']);
        $commonPart = trim($this->longest_common_substring($url, $scriptName));
        $urlParts = str_ireplace($commonPart, '', $url);
        if (!$urlParts == "") {
            $urlParts = trim($urlParts, '/');
            $urlArray = parse_url($urlParts);
            $this->url = explode('/', $urlArray['path']);
            return;
        }
        $this->url = [];
    }
}
