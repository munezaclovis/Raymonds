<?php

declare(strict_types=1);

namespace Raymonds\Session;

use Raymonds\Session\Exception\SessionException;
use Raymonds\Session\SessionInterface;
use Raymonds\Session\Storage\SessionStorageInterface;
use Raymonds\Session\Exception\SessionInvalidArgumentException;

class Session implements SessionInterface
{
    /**
     * @var SessionStorageInterface
     */
    protected SessionStorageInterface $storage;

    /**
     * @var string
     */
    protected string $sessionName;

    protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

    public function __construct(string $sessionName, ?SessionStorageInterface $storage)
    {
        $this->checkValidSessionKey($sessionName);
        $this->sessionName = $sessionName;
        $this->storage = $storage;
    }

    public function set(string $key, mixed $value)
    {
        try {
            return $this->storage->setSession($key, $value);
        } catch (\Throwable $th) {
            throw new SessionException('An exception was thrown while setting a session variable. ' . $th);
        }
    }

    public function setArray(string $key, mixed $value)
    {
        try {
            return $this->storage->setArraySession($key, $value);
        } catch (\Throwable $th) {
            throw new SessionException('An exception was thrown while setting a session array variable. ' . $th);
        }
    }

    public function get(string $key)
    {
        try {
            return $this->storage->getSession($key, null);
        } catch (\Throwable $th) {
            throw new SessionException('An exception was thrown while retriving a session variable. ' . $th);
        }
    }
    public function delete(string $key)
    {
        try {
            $this->storage->deleteSession($key);
        } catch (\Throwable $th) {
            throw new SessionException('An exception was thrown while deleting a session variable. ' . $th);
        }
    }

    public function invalidate(): void
    {
        $this->storage->invalidate();
    }

    public function flush(string $key, mixed $value = null)
    {
        try {
            $this->storage->flush($key, $value);
        } catch (\Throwable $th) {
            throw new SessionException($th->getMessage());
        }
    }

    public function has(string $key): bool
    {
        return $this->storage->hasSession($key);
    }

    protected function isSessionValid(string $key): bool
    {
        return preg_match(self::SESSION_PATTERN, $key) === 1;
    }

    protected function checkValidSessionKey($key): void
    {
        if ($this->isSessionValid($key) === false) {
            throw new SessionInvalidArgumentException($key . ' is not a valid session name');
        }
    }
}
