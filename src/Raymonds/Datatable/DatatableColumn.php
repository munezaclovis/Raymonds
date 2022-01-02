<?php

declare(strict_types=1);

namespace Raymonds\Datatable;

abstract class DatatableColumn implements DatatableColumnInterface
{
    abstract public function columns(): array;
}
