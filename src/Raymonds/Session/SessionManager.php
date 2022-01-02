<?php

declare(strict_types=1);

namespace Raymonds\Session;

use Raymonds\Session\Storage\SessionStorage;
use Raymonds\Yaml\Config;

class SessionManager
{

    public static function initialize()
    {
        return new Session('RaymondsCore', new SessionStorage(Config::file('session')));
    }
}
