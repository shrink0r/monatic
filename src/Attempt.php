<?php

namespace Shrink0r\Monatic;

use Exception;

class Attempt implements MonadInterface
{
    /**
     * @var MonadInterface Either Success or Error
     */
    private $result;

    /**
     * @var callable $codeBlock
     */
    private $codeBlock;

    /**
     * Wraps the given value inside a new Attempt monad.
     *
     * @param mixed $value
     *
     * @return Attempt
     */
    public static function unit($codeBlock)
    {
        return new static($codeBlock);
    }

    /**
     * Returns the result of the code-block execution attempt.
     *
     * @param callable $codeBlock Is never executed for this type.
     *
     * @return null
     */
    public function get(callable $codeBlock = null)
    {
        if (!$this->result) {
            $this->result = $this->run(new Success);
        }

        if ($this->result instanceof Success) {
            return is_callable($codeBlock) ? $codeBlock($this->result) : $this->result;
        }

        return $this->result;
    }

    /**
     * Returns a new Attempt monad that is bound to the given code-block.
     *
     * @param callable $codeBlock
     *
     * @return Attempt
     */
    public function bind(callable $codeBlock)
    {
        return static::unit(function ($result) use ($codeBlock) {
            $result = $this->run($result);
            if ($result instanceof Success) {
                return $codeBlock($result);
            } else {
                return $result;
            }
        });
    }

    /**
     * Creates a new Attempt monad.
     *
     * @param callable $codeBlock
     */
    protected function __construct(callable $codeBlock)
    {
        $this->codeBlock = $codeBlock;
        $this->result = null;
    }

    /**
     * Runs the monad's code-block.
     *
     * @param MonadInterface $prevResult
     * @param callable $next
     *
     * @return MonadInterface Either Success or Error in case an exception occured.
     */
    protected function run(MonadInterface $prevResult, callable $next = null)
    {
        try {
            $result = call_user_func($this->codeBlock, $prevResult);
            return ($result instanceof MonadInterface) ? $result : Success::unit($result);
        } catch (Exception $error) {
            return Error::unit($error);
        }
    }
}
