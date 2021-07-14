<?php

declare(strict_types=1);

namespace Raymonds\Http;

use Symfony\Component\HttpFoundation\Response;
use Raymonds\Base\Exception\BaseLogicException;

class ResponseHandler
{
    public function handler(): Response
    {
        try {
            return new Response;
        } catch (\Throwable $th) {
            throw new BaseLogicException('A required package extension "Symfony/http-foundation" is missing. ' . $th->getMessage());
        }
    }
}
