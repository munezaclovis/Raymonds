<?php

declare(strict_types=1);

namespace Raymonds\Session;

interface Sessioninterface
{
    public function get(string $key);

    public function set(string $key, mixed $value);

    public function setArray(string $key, mixed $value);

    public function delete(string $key);

    public function invalidate(): void;

    public function flush(string $key, mixed $value);

    public function has(string $key): bool;
}
