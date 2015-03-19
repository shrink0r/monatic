<?php

namespace Shrink0r\Monatic;

/**
 * Special subtype of the Many monad that wraps it's array-elements into Option values.
 */
class ManyOption extends Many
{
    /**
     * Unwraps the contained array and applies the optional $codeBlock to each element before returning it.
     *
     * @param callable $codeBlock
     *
     * @return array
     */
    public function unwrap(callable $codeBlock = null)
    {
        $unwrapValue = function ($value) {
            if ($value instanceof MonadInterface) {
                return $value->unwrap();
            } else {
                return $value;
            }
        };

        return array_map($unwrapValue, parent::unwrap($codeBlock));
    }

    /**
     * Creates a new ManyOption instance from the given array, thereby wrapping each array item into an Option.
     *
     * @param array $values
     */
    protected function __construct(array $values)
    {
        $wrapValue = function ($value) {
            return Option::wrap($value);
        };

        parent::__construct(array_map($wrapValue, $values));
    }
}
