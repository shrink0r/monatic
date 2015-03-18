<?php

namespace Shrink0r\Monatic;

class ManyOption extends Many
{
    public function __construct(array $values)
    {
        $wrapValue = function ($value) {
            return Option::wrap($value);
        };

        parent::__construct(array_map($wrapValue, $values));
    }

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
}
