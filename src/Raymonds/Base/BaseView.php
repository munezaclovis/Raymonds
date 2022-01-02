<?php

declare(strict_types=1);

namespace Raymonds\Base;

use Twig\Environment;
use Raymonds\Twig\TwigExtension;
use Raymonds\Yaml\Config;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class BaseView
{
    public function getTemplate(string $template, array $data = [])
    {
        static $twig;
        if ($twig === null) {
            $loader = new FilesystemLoader(ROOT . DS . 'App' . DS . 'View');
            $twig = new Environment($loader, Config::file('twig'));
            $twig->addExtension(new DebugExtension);
            $twig->addExtension(new TwigExtension);
        }
        return $twig->render($template, $data);
    }

    public function render(string $template, array $data = [])
    {
        echo $this->getTemplate($template, $data);
    }
}
