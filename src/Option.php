<?php

namespace Shrink0r\Monatic;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Wraps a given value, thereby providing fluent access to it's underlying properties.
 */
class Option extends AbstractMonad
{
    /**
     * @var mixed $value;
     */
    private $value;

    /**
     * @var PropertyAccess $accessor
     */
    private $accessor;

    /**
     * Wraps the given value inside a new Option instance.
     *
     * @param mixed $value
     *
     * @return Option Returns None if the given value is null.
     */
    public static function wrap($value)
    {
        return ($value === null) ? new None : new static($value);
    }

    /**
     * Unwraps the Option's value and applies the optional $codeBlock before returning it.
     *
     * @param callable $codeBlock
     *
     * @return mixed
     */
    public function unwrap(callable $codeBlock = null)
    {
        if (is_callable($codeBlock)) {
            return call_user_func($codeBlock, $this->value);
        } else {
            return $this->value;
        }
    }

    /**
     * Runs the given $codeBlock on the Option's value, if the value isn't null.
     *
     * @param callable $codeBlock Is expected to return the next value to be wrapped.
     *
     * @return Option Returns None if the next value is null.
     */
    public function andThen(callable $codeBlock)
    {
        if ($this->value === null) {
            return new None;
        } else {
            return static::wrap(call_user_func($codeBlock, $this->value));
        }
    }

    /**
     * Retrieves the Option value for the underlying property by name.
     *
     * This adds syntatic sugar to the Option monad, allowing to chain property/array access.
     * Example: Option::wrap($arr)->keyone->keytwo->etc->unwrap();
     *
     * @param string $propertyName
     *
     * @return Option Returns None if the property/key doesn't exist or equals null.
     */
    public function __get($propertyName)
    {
        return $this->andThen(
            function ($value) use ($propertyName) {
                return $this->accessValue($value, $propertyName);
            }
        );
    }

    /**
     * Creates a new Option instance, that wraps the given value.
     *
     * @param mixed $value
     */
    protected function __construct($value)
    {
        $this->value = ($value instanceof MonadInterface) ? $value->unwrap() : $value;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Internal helper method that is used to retrieve an underlying value from a given object/array.
     * If the given context(value) is scalar, it is returned as it was given.
     *
     * @param mixed $context The context to retrieve the value from.
     * @param string $key The property-name/array-key to use in order to read the value from the $context.
     *
     * @return mixed
     */
    protected function accessValue($context, $key)
    {
        if (is_array($context)) {
            return $this->accessor->getValue($context, "[{$key}]");
        } elseif (is_object($context)) {
            return $this->accessor->getValue($context, $key);
        } else {
            return $context;
        }
    }
}
