<?php

namespace Shrink0r\Monatic;

/**
 * Specifies the behavior, that must be provided by concrete monad implementations within "monatic".
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
    public static function unit($value);

    /**
     * Ununit the the value contained by a specific MonadInterface implementation.
     * In most cases the optonal $codeBlock allows to directly manipulate the value during retrieval.
     *
     * @param callable $codeBlock
     *
     * @return mixed
     */
    public function get(callable $codeBlock = null);

    /**
     * Process the given $codeBlock in the context of the contained value
     * and allow for continuation by returning a new monad instance.
     *
     * @param callable $codeBlock
     *
     * @return MonadInterface
     */
    public function bind(callable $codeBlock);


    /**
     * call an arbitrary method on the unitped value
     *
     * @param string $name
     * @param array $arguments
     *
     * @return MonadInterface
     */
    public function __call($name, array $arguments);
}
