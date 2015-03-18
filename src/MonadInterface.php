<?php

namespace Monatic;

interface MonadInterface
{
    public static function wrap($value);

    public function unwrap(callable $codeBlock = null);

    public function andThen(callable $codeBlock);
}
