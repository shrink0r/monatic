<?php

namespace Monatic;

use Symfony\Component\PropertyAccess\PropertyAccess;

class Many implements MonadInterface
{
    private $values;

    private $accessor;

    public function __construct(array $values)
    {
        $this->values = $values;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public static function wrap($values)
    {
        return new static(empty($values) ? [] : (is_array($values) ? $values : [ $values ]));
    }

    public function andThen(callable $codeBlock)
    {
        return static::wrap(
            array_reduce(array_map($codeBlock, $this->values), [ $this, 'flatMap' ], [])
        );
    }

    public function unwrap(callable $codeBlock = null)
    {
        if (is_callable($codeBlock)) {
            return array_map($codeBlock, $this->values);
        } else {
            return $this->values;
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

    protected function flatMap(array $values, MonadInterface $value)
    {
        $unwrapped = $value->unwrap();

        if (!is_array($unwrapped)) {
            $unwrapped = [ $unwrapped ];
        }

        return array_merge($values, $unwrapped);
    }
}
