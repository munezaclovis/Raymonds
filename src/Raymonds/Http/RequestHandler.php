<?php

declare(strict_types=1);

namespace Raymonds\Http;

use Symfony\Component\HttpFoundation\Request;
use Raymonds\Base\Exception\BaseLogicException;

class RequestHandler
{
    public function handler(): Request
    {
        try {
            return Request::createFromGlobals();
        } catch (\Throwable $th) {
            throw new BaseLogicException('A required package extension "Symfony/http-foundation" is missing. ' . $th->getMessage());
        }
    }
}
