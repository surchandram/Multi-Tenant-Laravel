<?php

namespace SAAS\App\Pages\Components;

use ReflectionClass;
use SAAS\App\Pages\Components\Contracts\PageComponentInterface;
use SAAS\Domain\Pages\Models\PageComponent;

abstract class AbstractPageComponent implements PageComponentInterface
{
    public string $type;

    public string $typeClass;

    public function __construct(
        public readonly string $key,
        public readonly mixed $value,
    ) {
        $this->type = $this->type();
        $this->typeClass = $this->typeClass();
    }

    abstract public static function fromArray(array $data);

    abstract public static function fromModel(PageComponent $pageComponent);

    public function key()
    {
        return $this->key;
    }

    public function value()
    {
        return $this->value;
    }

    public function type()
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function typeClass()
    {
        return (new ReflectionClass($this))->getName();
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
