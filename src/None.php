<?php

namespace Monatic;

class None extends Option
{
    public function __construct()
    {
        parent::__construct(null);
    }

    public static function wrap($value)
    {
        return new static(null);
    }

    public function unwrap(callable $codeBlock = null)
    {
        return parent::unwrap();
    }
}
