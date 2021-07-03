<?php

declare(strict_types=1);

namespace Raymonds\DatabaseConnection;

use PDO;

interface DatabaseConnectionInterface
{
    /**
     * create a PDO instance
     *
     * @return PDO
     */
    public function open(): PDO;

    /**
     * close/destroy the PDO instance
     */
    public function close(): void;
}
