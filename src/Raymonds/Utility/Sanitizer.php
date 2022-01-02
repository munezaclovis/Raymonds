<?php

declare(strict_types=1);

namespace Raymonds\Utility;

use Raymonds\Base\Exception\BaseTypeError;

class Sanitizer
{
    public static function clean(mixed $data)
    {
        switch (gettype($data)) {
            case "array":
                return self::array($data);
                break;
            case "integer":
                return self::integer($data);
                break;
            case "double":
            case "float":
                return self::float($data);
                break;
            case "string":
                return self::string($data);
                break;
            default:
                throw new BaseTypeError('Variable $data of type ' . gettype($data) . ' is not supported by Sanitizer::clean');
        }
    }

    private static function string(string $data)
    {
        return trim(filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_SANITIZE_STRING));
    }

    private static function integer(int $data)
    {
        return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
    }

    private static function float(float $data)
    {
        return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    private static function array(array $data)
    {
        array_walk_recursive($data, function (&$value) {
            $value = self::clean($value);
        });
        return $data;
    }
}
