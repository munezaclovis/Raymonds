<?php

declare(strict_types=1);

namespace Raymonds\DatabaseConnection;

use PDO;
use Raymonds\DatabaseConnection\DatabaseConnectionInterface;
use Raymonds\DatabaseConnection\Exception\DatabaseConnectionException;

class DatabaseConnection implements DatabaseConnectionInterface
{
    /**
     * @var PDO
     */
    protected PDO $db;

    /**
     * @var array
     */
    protected array $credentials;

    /**
     * initiate credentials
     *
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @inheritDoc
     */
    public function open(): PDO
    {
        try {
            $params = [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ];

            $this->db = new PDO(
                $this->credentials['dsn'],
                $this->credentials['username'],
                $this->credentials['password'],
                $params
            );
        } catch (\PDOException $exception) {
            throw new DatabaseConnectionException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     */
    public function close(): void
    {
        $this->db = null;
    }
}
