<?php

declare(strict_types=1);

namespace Raymonds\Session;

use Raymonds\Session\Storage\SessionStorage;

class SessionManager
{

    public function initialize()
    {
        $factory = new SessionFactory();
        return $factory->create('', SessionStorage::class, array());
    }
}
