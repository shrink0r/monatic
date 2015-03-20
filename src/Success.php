<?php

namespace Shrink0r\Monatic;

class Success extends Maybe
{
    public function __construct($value = null)
    {
        parent::__construct($value);
    }
}
