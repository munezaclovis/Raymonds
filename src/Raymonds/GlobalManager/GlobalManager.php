<?php

declare(strict_types=1);

namespace Raymonds\GlobalManager;

use Raymonds\GlobalManager\GlobalManagerInterface;
use Raymonds\GlobalManager\Exception\GlobalManagerException;
use Raymonds\GlobalManager\Exception\GlobalManagerInvalidArgumentException;

class GlobalManager implements GlobalManagerInterface
{
    public static function set(string $key, mixed $value): void
    {
        $GLOBALS[$key] = $value;
    }

    public static function get(string $key): mixed
    {
        self::isValidGlobal($key);
        try {
            return $GLOBALS[$key];
        } catch (\Throwable $th) {
            throw new GlobalManagerException('Unable to retrieve global variable value of null');
        }
    }

    private static function isValidGlobal(string $key): void
    {
        if (!isset($GLOBALS[$key])) {
            throw new GlobalManagerInvalidArgumentException('Invalid Global key. Key does not exist in the $GLOBAL variable.');
        }
        if (empty($key)) {
            throw new GlobalManagerInvalidArgumentException('Argument cannot be empty');
        }
    }
}
