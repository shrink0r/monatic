<?php

namespace Shrink0r\Monatic;

/**
 * Special subtype of the Many monad, that composes it's collection-items into Maybe monads.
 */
class ManyMaybe extends Many
{
    /**
     * Returns the contained collection and applies an optional code-block to each element before returning it.
     *
     * @param callable $codeBlock
     *
     * @return array
     */
    public function get(callable $codeBlock = null)
    {
        $getValue = function (Maybe $value) {
            return $value->get();
        };

        return array_map($getValue, parent::get($codeBlock));
    }

    /**
     * Creates a new ManyMaybe instance from the given collection,
     * thereby composing each collection item into an Maybe monad.
     *
     * @param array $values
     */
    protected function __construct(array $values)
    {
        $unit = function ($value) {
            return Maybe::unit($value);
        };

        parent::__construct(array_map($unit, $values));
    }
}
