<?php

declare(strict_types=1);

namespace Raymonds\Session;

use Raymonds\Session\Sessioninterface;
use Raymonds\Session\Storage\SessionStorageInterface;
use Raymonds\Session\Exception\SessionStorageInvalidArgumentException;

class SessionFactory
{

    public function __construct()
    {
    }

    public function create(string $sessionName, string $storageString, array $options): Sessioninterface
    {
        $storageObject = new $storageString($options);
        if (!$storageObject instanceof SessionStorageInterface) {
            throw new SessionStorageInvalidArgumentException($storageString . ' is not instance of SessionStorage');
        }
        return new Session($sessionName, $storageObject);
    }
}
