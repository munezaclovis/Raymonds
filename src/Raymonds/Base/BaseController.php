<?php

declare(strict_types=1);

namespace Raymonds\Base;

use Raymonds\Base\BaseView;
use Raymonds\Base\Exception\BaseLogicException;

class BaseController
{
    protected array $routeParams;

    private BaseView $twig;

    public function __construct(array $routeParams)
    {
        $this->routeParams = $routeParams;
        $this->twig = new BaseView;
    }

    public function render(string $template, array $data = [])
    {
        if ($this->twig === null) {
            throw new BaseLogicException('Twig is not available');
        }
        return $this->twig->getTemplate($template, $data);
    }
}
