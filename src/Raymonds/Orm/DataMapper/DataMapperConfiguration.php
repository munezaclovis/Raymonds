<?php

declare(strict_types=1);

namespace Raymonds\Orm\DataMapper;

use Raymonds\Orm\DataMapper\Exception\DataMapperInvalidArgumentException;

class DataMapperConfiguration
{
    /**
     * @var array
     */
    private array $credentials = [];

    /**
     * Constructor
     *
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Get database credentials corresponding to the driver given
     *
     * @param string $driver
     * @return array
     */
    public function getDatabaseCredentials(string $driver): array
    {
        $connectionArray = [];
        foreach ($this->credentials as $credential) {
            if (array_key_exists($driver, $credential)) {
                $connectionArray = $credential[$driver];
            }
        }
        return $connectionArray;
    }

    /**
     * check if credentials are valid
     *
     * @param string $driver
     * @return boolean
     * @throws DataMapperInvalidArgumentException
     */
    public function isCredentialsValid(string $driver)
    {
        if (empty($driver) && !is_string($driver)) {
            throw new DataMapperInvalidArgumentException("Invalid argument. This is either missing or the data type is invalid");
        }

        if (!is_array($this->credentials)) {
            throw new DataMapperInvalidArgumentException('Invalid credentials');
        }
        if (!in_array($driver, array_keys($this->credentials[$driver]))) {
            throw new DataMapperInvalidArgumentException('Invalid or unsupport database driver.');
        }
    }
}
