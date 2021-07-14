<?php

declare(strict_types=1);

namespace Raymonds\Flash;

use Raymonds\Flash\FlashTypes;

interface FlashInterface
{
    public static function add(string $message, string $type = FlashTypes::SUCCESS): void;

    public static function get();
}
