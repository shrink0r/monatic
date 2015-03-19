<?php

namespace Shrink0r\Monatic;

/**
 * Acts as a null-object for the Option monad.
 */
class None extends Option
{
    /**
     * Creates a new None instance.
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    /**
     * Wraps the given value inside a new None instance, effectively nulling the value.
     *
     * @param mixed $value
     *
     * @return None
     */
    public static function wrap($value)
    {
        return new static(null);
    }

    /**
     * Unwraps the None instance's (null)value.
     *
     * @param callable $codeBlock Is never executed for this type.
     *
     * @return null
     */
    public function unwrap(callable $codeBlock = null)
    {
        return parent::unwrap();
    }
}
