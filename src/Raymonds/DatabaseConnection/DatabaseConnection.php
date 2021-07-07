<?php

declare(strict_types=1);

namespace Raymonds\DatabaseConnection;

use PDO;
use PDOException;
use Raymonds\DatabaseConnection\DatabaseConnectionInterface;
use Raymonds\DatabaseConnection\Exception\DatabaseConnectionException;

class DatabaseConnection implements DatabaseConnectionInterface
{
    /**
     * @var PDO
     */
    protected static ?PDO $connection = null;

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
            if (is_null(self::$connection)) {
                $params = [
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ];

                self::$connection = new PDO(
                    $this->credentials['dsn'],
                    $this->credentials['username'],
                    $this->credentials['password'],
                    $params
                );
            }
        } catch (PDOException $exception) {
            throw new DatabaseConnectionException($exception->getMessage(), (int) $exception->getCode());
        }
        return $this->connection;
    }

    /**
     * @inheritDoc
     */
    public function close(): void
    {
        self::$connection = null;
    }
}
