<?php

declare(strict_types=1);

namespace Raymonds\Model;

use Raymonds\Base\BaseModel;
use Raymonds\Base\Exception\BaseException;
use Raymonds\Orm\OrmManager;
use Raymonds\Orm\DataRepository\DataRepository;
use Raymonds\Base\Exception\BaseInvalidArgumentException;
use Raymonds\Orm\DataRepository\DataRepositoryException;
use Raymonds\Orm\EntityManager\Crud;
use Raymonds\Utility\Sanitizer;

class Model extends BaseModel
{
    protected string $tableName;

    protected string $primaryKey;

    protected array $attributes;

    private Crud $crud;

    final public function __construct()
    {
        $this->onConstruct();
        $this->crud = (new OrmManager($this->tableName, $this->primaryKey))->initialize();
    }

    public function assign(array $args): static
    {
        foreach ($args as $key => $value) {
            if (in_array($key, $this->attributes)) {
                $this->{$key} = Sanitizer::clean($value);
            }
        }
        return $this;
    }

    public static function fill(array $data): static
    {
        return (new static)->assign($data);
    }

    public function getCrud(): Crud
    {
        if (!isset($this->crud)) {
            throw new BaseException('Cannot access variable $crud when it has not been initialized yet. Hint: Constructor has not been run');
        }
        return $this->crud;
    }

    public static function find(int|string|array $args): array
    {
        $self = new static;
        if (is_array($args)) {
            return $self->getCrud()->select(array_merge($args, ['class' => static::class]));
        }

        return (new static)->getCrud()->select([
            'conditions' => [
                $self->primaryKey => $args
            ],
            'class' => static::class
        ]);
    }

    public static function findFirst(int|string|array $args): static
    {
        $self = new static;
        return (new static)->getCrud()->select([
            'conditions' => [
                $self->primaryKey => $args
            ],
            'class' => static::class
        ])[0];
    }

    public static function all(): array
    {
        return (new static)->getCrud()->select([
            'limit' => 100,
            'class' => static::class
        ]);
    }

    public static function where(string $field, int|string $value): array
    {
        return (new static)->getCrud()->select([
            'conditions' => [
                $field => $value
            ],
            'class' => static::class
        ]);
    }

    public function save()
    {
        $values = [];
        foreach ($this->attributes as $key) {
            $values[$key] = $this->{$key};
        }

        return (new static)->getCrud()->save([
            'fields' => $values,
            'class' => static::class
        ]);
    }

    public static function create(array $args)
    {
        return (new static)->assign($args)->save();
    }

    public static function delete(int|string|array $arg)
    {
        return (new static)->getCrud()->delete([]);
    }

    public static function update(string $primaryKey, array $conditions = []): bool
    {
        return true;
    }

    public function validate()
    {
    }

    public function beforeSave()
    {
        return true;
    }

    public function afterSave()
    {
        return true;
    }

    public function beforeDelete()
    {
        return true;
    }

    public function afterDelete()
    {
        return true;
    }

    public function onConstruct(): void
    {
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }
}
