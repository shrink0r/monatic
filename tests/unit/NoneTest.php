<?php

namespace Shrink0r\Monatic\Tests;

use Shrink0r\Monatic\None;
use PHPUnit_Framework_TestCase;

class NoneTest extends PHPUnit_Framework_TestCase
{
    public function testAndThen()
    {
        $none = None::wrap(23)->foobar;

        $this->assertNull($none->unwrap());
    }

    public function testCreate()
    {
        $none = new None;

        $this->assertNull($none->unwrap());
    }

    public function testWrap()
    {
        $none = None::wrap(23);

        $this->assertNull($none->unwrap());
    }
}
