<?php

namespace Shrink0r\Monatic;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Wraps a given value and provides fluent access to it's underlying properties.
 */
class Maybe implements MonadInterface
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
     * Wraps the given value inside a new Maybe monad.
     *
     * @param mixed $value
     *
     * @return Maybe Returns None if the given value is null.
     */
    public static function unit($value)
    {
        return new static($value);
    }

    /**
     * Returns the monad's value and applies an optional code-block before returning it.
     *
     * @param callable $codeBlock
     *
     * @return mixed
     */
    public function get(callable $codeBlock = null)
    {
        if (is_callable($codeBlock)) {
            return call_user_func($codeBlock, $this->value);
        }
        return $this->value;
    }

    /**
     * Runs the given code-block on the monad's value, if the value isn't null.
     *
     * @param callable $codeBlock Is expected to return the next value to be unitped.
     *
     * @return Maybe Returns None if the next value is null.
     */
    public function bind(callable $codeBlock)
    {
        if ($this->value === null) {
            return new None;
        }
        return static::unit(call_user_func($codeBlock, $this->value));
    }

    /**
     * Retrieves the monad's value for the underlying property by name.
     *
     * This adds syntatic sugar to the Maybe monad, allowing to chain property/array access.
     * Example: Maybe::unit($arr)->keyone->keytwo->etc->get();
     *
     * @param string $propertyName
     *
     * @return Maybe Returns None if the property/key doesn't exist or equals null.
     */
    public function __get($propertyName)
    {
        return $this->bind(function ($value) use ($propertyName) {
            return $this->accessValue($value, $propertyName);
        });
    }

    /**
     * Calls an arbitrary method on the monad's value and returns a monad with the result.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return MonadInterface
     */
    public function __call($methodName, array $arguments)
    {
        return $this->bind(function ($value) use ($methodName, $arguments) {
            $callable = [ $value, $methodName ];

            $result = null;
            if (is_callable($callable)) {
                $result = call_user_func_array([$value, $methodName], $arguments);
            }

            return static::unit($result);
        });
    }

    /**
     * Creates a new Maybe monad.
     *
     * @param mixed $value
     */
    protected function __construct($value)
    {
        $this->value = ($value instanceof MonadInterface) ? $value->get() : $value;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Internal helper method that is used to retrieve an underlying value from a given context (object/array).
     * If the given context is scalar, it is returned as the resulting value.
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
        }
        if (is_object($context)) {
            return $this->accessor->getValue($context, $key);
        }
        return $context;
    }
}
