<?php

namespace Shrink0r\Monatic;

class Eventually implements MonadInterface
{
    protected $codeBlock;

    protected $result;

    public function __construct(callable $codeBlock)
    {
        $this->codeBlock = $codeBlock;
        $this->result = null;
    }

    public static function wrap($codeBlock)
    {
        assert(is_callable($codeBlock), "'Eventually' can only be created from callables.");

        return new static($codeBlock);
    }

    public function andThen(callable $codeBlock)
    {
        assert($this->result === null, "'Eventually' instance may not be mutated after being unwrapped.");

        return static::wrap(
            function ($success) use (&$codeBlock) {
                $this->run(
                    function ($value) use (&$codeBlock, $success) {
                        return $codeBlock($value)->run($success);
                    }
                );
            }
        );
    }

    public function unwrap(callable $codeBlock = null)
    {
        if ($this->result === null) {
            $this->run(
                function ($value) use (&$codeBlock) {
                    $this->result = $value;
                    if (is_callable($codeBlock)) {
                        $codeBlock($this->result);
                    }
                }
            );

            return $this;
        } else {
            if (is_callable($codeBlock)) {
                $codeBlock($this->result);
            }
            return $this->result;
        }
    }

    protected function run(callable $success = null)
    {
        call_user_func($this->codeBlock, $success);
    }
}
