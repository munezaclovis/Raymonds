<?php

declare(strict_types=1);

namespace Raymonds\Session\Storage;

use Raymonds\Session\Storage\SessionStorageInterface;

abstract class AbstractSessionStorage implements SessionStorageInterface
{
    protected array $options = [];

    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->iniSet();
        if ($this->sessionStarted()) {
            session_unset();
            session_destroy();
        }
        $this->start();
    }

    public function setSessionName(string $sessionName): void
    {
        session_name($sessionName);
    }

    public function getSessionName(): string
    {
        return session_name();
    }

    public function setSessionID(string $sessionID): void
    {
        session_id($sessionID);
    }

    public function getSessionID(): string
    {
        return session_id();
    }

    public function iniSet()
    {
        ini_set('session.gc_maxlifetime', $this->options['gc_maxlifetime']);
        ini_set('session.gc_divisor', $this->options['gc_divisor']);
        ini_set('session.gc_probability', $this->options['gc_probability']);
        ini_set('session.cookie_lifetime', $this->options['cookie_lifetime']);
        ini_set('session.use_cookies', $this->options['use_cookies']);
    }

    public function sessionStarted()
    {
        return php_sapi_name() !== 'cli' ? $this->getSessionID() !== '' : false;
    }

    public function startSession()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    }

    public function start()
    {
        $this->setSessionName($this->options['session_name']);
        $domain = $this->options['domain'] ?? $_SERVER['SERVER_NAME'];
        $secure = $this->options['secure'] ?? isset($_SERVER['HTTPS']);

        session_set_cookie_params($this->options['lifetime'], $this->options['path'], $domain, $secure, $this->options['httponly']);

        $this->startSession();
    }
}
