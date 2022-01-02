<?php

declare(strict_types=1);

namespace Raymonds\Datatable;

interface DatatableInterface
{
    public function table(): ?string;

    public function pagination(): ?string;
}
