<?php

declare(strict_types=1);

namespace Raymonds\Base;

abstract class BaseModel
{
    public abstract function onConstruct(): void;
}
