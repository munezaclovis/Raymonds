<?php

declare(strict_types=1);

namespace Raymonds\Datatable;

use Raymonds\Datatable\DatatableColumn;

class Datatable extends AbstractDatatable
{
    protected DatatableColumn $dataColumnObject;

    protected array $dataColumns;

    protected array $sortController;

    public function __construct(array $dataRepository = [], array $sortController = [])
    {
        $this->dataColumnObject = new DatatableColumn;
        $this->dataColumns = $this->dataColumnObject->columns();
        $this->sortController = $sortController;
        $this->getRepositoryParts($dataRepository);
    }

    private function getRepositoryParts(array $dataRepository): void
    {
    }

    public function table(): ?string
    {
        return '';
    }

    public function pagination(): ?string
    {
        return '';
    }
}
