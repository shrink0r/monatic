<?php

namespace Shrink0r\Monatic;

/**
 * Wraps a given callable, which will eventually invoke a given success callback, when it can provide a value.
 * Basically this allows to chain async calls in a straight line without nesting callbacks.
 */
class Eventually extends Monad
{
    /**
     * @var callable $codeBlock
     */
    protected $codeBlock;

    /**
     * @var mixed $result
     */
    protected $result;

    /**
     * Wraps the given callable in a new Eventually instance.
     *
     * @param callable $codeBlock
     *
     * @return Eventually
     */
    public static function unit($codeBlock)
    {
        assert(is_callable($codeBlock), "'Eventually' can only be created from callables.");

        return new static($codeBlock);
    }

    /**
     * Eventually provides the a value resulting from running the monad's code-block.
     * If the value can not be provided at the moment,
     * a pointer to self is returned and the $codeBlock is executed when the value becomes available.
     *
     * @param callable $codeBlock
     *
     * @return mixed Returns an instance of Eventually, if the value wasn't available yet.
     */
    public function get(callable $codeBlock = null)
    {
        if ($this->result === null) {
            $this->run(function ($value) use ($codeBlock) {
                $this->result = $value;
                if (is_callable($codeBlock)) {
                    $codeBlock($this->result);
                }
            });

            return $this;
        } else {
            if (is_callable($codeBlock)) {
                $codeBlock($this->result);
            }
            return $this->result;
        }
    }

    /**
     * Binds the given callable to the monad's managed code-block's successful execution.
     *
     * @param callable $codeBlock Is expected to return an instance of Eventually.
     *
     * @return Eventually
     */
    public function bind(callable $codeBlock)
    {
        assert($this->result === null, "'Eventually' instance may not be mutated after being getped.");

        return static::unit(function ($success) use ($codeBlock) {
            $this->run(function ($value) use ($codeBlock, $success) {
                return $codeBlock($value)->run($success);
            });
        });
    }

    /**
     * Creates a new Eventually instance from the given callable.
     *
     * @param callable $codeBlock
     */
    protected function __construct(callable $codeBlock)
    {
        $this->codeBlock = $codeBlock;
        $this->result = null;
    }

    /**
     * Executes the monad's managed code-block, passing it the given success callback.
     *
     * @param callable $success
     */
    protected function run(callable $success = null)
    {
        call_user_func($this->codeBlock, $success);
    }

    public function __call($name, array $arguments)
    {
        return $this;
    }
}
