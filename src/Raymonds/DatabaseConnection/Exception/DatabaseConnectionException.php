<?php

declare(strict_types=1);

namespace Raymonds\DatabaseConnection\Exception;

use PDO;
use PDOException;

class DatabaseConnectionException extends PDOException
{
    protected $message;
    protected $code;

    public function __construct($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
