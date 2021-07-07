<?php

declare(strict_types=1);

namespace Raymonds\Orm\QueryBuilder;

interface QueryBuilderInterface
{
    /**
     * Insert query string
     *
     * @return string
     * @throws QueryBuilderException
     */
    public function insertQuery(): string;

    /**
     * Update query string
     *
     * @return string
     * @throws QueryBuilderException
     */
    public function updateQuery(): string;

    /**
     * Select query string
     *
     * @return string
     * @throws QueryBuilderException
     */
    public function selectQuery(): string;

    /**
     * Delete query string
     *
     * @return string
     * @throws QueryBuilderException
     */
    public function deleteQuery(): string;

    /**
     * Search query string
     *
     * @return string
     * @throws QueryBuilderException
     */
    public function searchQuery(): string;

    /**
     * Raw query string
     *
     * @return string
     * @throws QueryBuilderException
     */
    public function rawQuery(): string;
}
