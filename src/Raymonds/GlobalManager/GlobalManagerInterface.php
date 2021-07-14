<?php

declare(strict_types=1);

namespace Raymonds\GlobalManager;

interface GlobalManagerInterface
{
    /**
     * Set global value
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, mixed $value): void;

    /**
     * Get global value
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed;
}
