<?php

declare(strict_types=1);

namespace Raymonds\Traits;

use Raymonds\Base\Exception\BaseLogicException;
use Raymonds\GlobalManager\GlobalManager;
use Raymonds\Session\SessionManager;

trait SystemTrait
{
    public static function sessionInit(bool $useSessionGlobal = false)
    {
        $session = SessionManager::initialize();
        if (!$session) {
            throw new BaseLogicException('Please enable session in the session.yaml configuration file');
        } else if ($useSessionGlobal === true) {
            GlobalManager::set('global_session', $session);
        } else {
            return $session;
        }
    }
}
