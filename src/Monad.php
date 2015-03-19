<?php

namespace Shrink0r\Monatic;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Base class that can be extended when implementing the MonadInterface.
 */
abstract class Monad implements MonadInterface
{
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
        return $this->bind(function($value) use ($methodName, $arguments) {
            return static::unit(call_user_func([$value, $methodName], $arguments));
        });
    }
}
