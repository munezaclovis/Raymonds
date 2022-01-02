<?php

declare(strict_types=1);

namespace Raymonds\Traits;

use Raymonds\Base\Exception\BaseInvalidArgumentException;
use Raymonds\Base\Exception\BaseOutOfBoundsException;

trait ArrayTrait
{
    public function isArray(array $data)
    {
        if (!is_array($data)) {
            throw new BaseInvalidArgumentException('Argument should not be empty');
        }
    }

    public function isEmpty(array $data)
    {
        if (empty($data)) {
            throw new BaseInvalidArgumentException('Argument should not be empty');
        }
    }

    public function hasKey(string $key, array $data)
    {
        if (!array_key_exists($key, $data)) {
            throw new BaseOutOfBoundsException("Key does {$key} not exist in the array");
        }
    }

    public function hasKeys(array $keys, array $data)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new BaseOutOfBoundsException("Keys (" . implode(', ', $keys) . ") specified do not exist in the array");
            }
        }
    }
}
