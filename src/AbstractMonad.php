<?php

namespace Shrink0r\Monatic;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Wraps a given array, thereby providing recursive+fluent access to any underlying collections.
 */
abstract class AbstractMonad implements MonadInterface
{
    /**
     * call an arbitrary method on the wrapped value
     * and wrap the result again.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return MonadInterface
     */
    public function __call($name, array $arguments)
    {
        return $this->andThen(function($value) use ($name, $arguments) {
            return static::wrap(
                call_user_func([$value, $name], $arguments)
            );
        });
    }
}
