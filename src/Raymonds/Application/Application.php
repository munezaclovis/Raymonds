<?php

declare(strict_types=1);

namespace Raymonds\Application;

use Raymonds\Yaml\Config;
use Raymonds\Traits\SystemTrait;
use Raymonds\Application\Environment;
use Raymonds\ErrorHandling\ErrorHandling;
use Raymonds\GlobalManager\GlobalManager;
use Raymonds\Router\Router;
use Raymonds\Router\RouterManager;

class Application
{
    use SystemTrait;

    protected string $appRoot;

    public function __construct(string $appRoot)
    {
        $this->appRoot = $appRoot;
    }

    public function run(): self
    {
        $this->constants();
        if (version_compare($phpVersion = PHP_VERSION, $frameworkVersion = Environment::RAYMONDS_MIN_VERSION, '<')) {
            die(sprintf('The Raymonds framework requires at least PHP Version %s, you are running PHP version %s.', $frameworkVersion, $phpVersion));
        }
        $this->environment();
        $this->errorHandler();
        return $this;
    }

    private function constants(): void
    {
        define('APP_ROOT', $this->appRoot);
        define('CONFIG_PATH', APP_ROOT . DS . 'Config');
        define('TEMPLATE_PATH', APP_ROOT . DS . 'App' . DS . 'views');
        define('LOG_DIR', APP_ROOT . DS . 'tmp' . DS . 'log');
    }

    private function environment()
    {
        ini_set('default_charset', 'UTF-8');
    }

    private function errorHandler()
    {
        (new ErrorHandling)->handle();
    }

    public function setSession(): self
    {
        SystemTrait::sessionInit(true);
        return $this;
    }

    public function handleRoute(): self
    {
        (new Router)->dispatch();

        return $this;
    }
}
