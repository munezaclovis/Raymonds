<?php

declare(strict_types=1);

namespace Raymonds\Orm\QueryBuilder;

use Raymonds\Orm\QueryBuilder\Exception\QueryBuilderException;
use Raymonds\Orm\QueryBuilder\QueryBuilderInterface;


class QueryBuilderFactory
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * create new QueryBuilder instance
     *
     * @param string $queryBuilderString
     * @return QueryBuilderInterface
     * @throws QueryBuilderException
     */
    public function create(string $queryBuilderString): QueryBuilderInterface
    {
        $queryBuilderObject = new $queryBuilderString();

        if (!$queryBuilderObject instanceof QueryBuilderInterface) {
            throw new QueryBuilderException($queryBuilderString . ' is not a valid Query builder interface');
        }
        return new $queryBuilderObject;
    }
}
