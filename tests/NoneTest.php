<?php

namespace Shrink0r\Monatic\Tests;

use Shrink0r\Monatic\None;
use PHPUnit_Framework_TestCase;

class NoneTest extends PHPUnit_Framework_TestCase
{
    public function testAndThen()
    {
        $none = None::unit(23)->foobar;

        $this->assertNull($none->get());
    }

    public function testCreate()
    {
        $none = new None;

        $this->assertNull($none->get());
    }

    public function testWrap()
    {
        $none = None::unit(23);

        $this->assertNull($none->get());
    }
}
