<?php

namespace Shrink0r\Monatic;

/**
 * Specifies the behavior to be exposed by concrete monad implementations within "monatic".
 * Wtf is a monad?
 * https://en.wikipedia.org/wiki/Monad_(functional_programming)
 */
interface MonadInterface
{
    /**
     * Wrap the given value inside a specific MonadInterface implementation.
     *
     * @param mixed $value A value that is specific to a concrete monad.
     *
     * @return MonadInterface
     */
    public static function wrap($value);

    /**
     * Unwrap the the value contained by a specific MonadInterface implementation.
     * In most cases the optonal $codeBlock allows to directly manipulate the value during retrieval.
     *
     * @param callable $codeBlock
     *
     * @return mixed
     */
    public function unwrap(callable $codeBlock = null);

    /**
     * Process the given $codeBlock in the context of the contained value
     * and allow for continuation by returning a new monad instance.
     *
     * @param callable $codeBlock
     *
     * @return MonadInterface
     */
    public function andThen(callable $codeBlock);


    /**
     * call an arbitrary method on the wrapped value
     *
     * @param string $name
     * @param array $arguments
     *
     * @return MonadInterface
     */
    public function __call($name, array $arguments);
}
