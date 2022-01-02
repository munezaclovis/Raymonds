<?php

declare(strict_types=1);

namespace App\Model\Datatables;

use Raymonds\Datatable\DatatableColumn;

class UsersColumns extends DatatableColumn
{
    public function columns(): array
    {
        return [
            [
                'db_row' => 'id',
                'dt_row' => 'ID',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ], [
                'db_row' => 'fname',
                'dt_row' => 'firstName',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ], [
                'db_row' => 'lname',
                'dt_row' => 'lastName',
                'class' => '',
                'show_column' => true,
                'sortable' => true,
                'formatter' => ''
            ], [
                'db_row' => 'email',
                'dt_row' => 'email',
                'class' => '',
                'show_column' => true,
                'sortable' => true,
                'formatter' => ''
            ], [
                'db_row' => 'password',
                'dt_row' => 'password',
                'class' => '',
                'show_column' => false,
                'sortable' => false,
                'formatter' => ''
            ], [
                'db_row' => '',
                'dt_row' => 'Action',
                'class' => '',
                'show_column' => true,
                'sortable' => false,
                'formatter' => ''
            ],
        ];
    }
}
