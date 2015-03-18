<?php

namespace Monatic;

use Symfony\Component\PropertyAccess\PropertyAccess;

class Option implements MonadInterface
{
    private $value;

    private $accessor;

    public function __construct($value)
    {
        $this->value = ($value instanceof MonadInterface) ? $value->unwrap() : $value;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public static function wrap($value)
    {
        return ($value === null) ? new None : new static($value);
    }

    public function unwrap(callable $codeBlock = null)
    {
        if (is_callable($codeBlock)) {
            return call_user_func($codeBlock, $this->value);
        } else {
            return $this->value;
        }
    }

    public function andThen(callable $codeBlock)
    {
        if ($this->value === null) {
            return new None;
        } else {
            return call_user_func($codeBlock, $this->value);
        }
    }

    public function __get($propertyName)
    {
        return $this->andThen(
            function ($value) use ($propertyName) {
                return static::wrap($this->accessValue($value, $propertyName));
            }
        );
    }

    protected function accessValue($value, $key)
    {
        if (is_array($value)) {
            return $this->accessor->getValue($value, "[{$key}]");
        } elseif (is_object($value)) {
            return $this->accessor->getValue($value, $key);
        } else {
            return $value;
        }
    }
}
