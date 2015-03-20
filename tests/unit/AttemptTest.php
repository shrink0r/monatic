<?php

namespace Shrink0r\Monatic\Tests;

use Shrink0r\Monatic\Attempt;
use Shrink0r\Monatic\Success;
use Shrink0r\Monatic\Error;
use Exception;
use PHPUnit_Framework_TestCase;

class AttemptTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessResult()
    {
        $result = Attempt::unit(function ($result) {
            return 23;
        })->bind(function ($result) {
            return $result->get() * 2;
        })->get();

        $this->assertInstanceOf(Success::CLASS, $result);
        $this->assertEquals(46, $result->get());
    }

    public function testErrorResult()
    {
        $result = Attempt::unit(function ($result) {
            throw new Exception("Snafu!");
        })->bind(function ($result) {
            return $result->get() * 2;
        })->get();

        $this->assertInstanceOf(Error::CLASS, $result);
        $this->assertEquals("Snafu!", $result->message->get());
    }
}
