<?php

declare(strict_types=1);

namespace App\Model;

use Raymonds\Model\Model;

class Users extends Model
{
    protected string $tableName = "users";

    protected string $primaryKey = "id";

    public function onConstruct(): void
    {
        $this->attributes = ['fname', 'lname', 'username', 'password', 'acl', 'deleted',];
    }
}
