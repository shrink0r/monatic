<?php

namespace Shrink0r\Monatic;

/**
 * Acts as a null-value for the Maybe monad.
 */
class None extends Maybe
{
    /**
     * Creates a new None monad.
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    /**
     * Wraps the given value inside a new None monad, effectively nulling the value.
     *
     * @param mixed $value
     *
     * @return None
     */
    public static function unit($value)
    {
        return new static(null);
    }

    /**
     * Returns the monad's value (always null).
     *
     * @param callable $codeBlock Is never executed for this type.
     *
     * @return null
     */
    public function get(callable $codeBlock = null)
    {
        return null;
    }
}
