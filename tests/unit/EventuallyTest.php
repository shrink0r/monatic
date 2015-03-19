<?php

namespace Shrink0r\Monatic\Tests;

use Shrink0r\Monatic\Eventually;
use PHPUnit_Framework_TestCase;

class EventuallyTest extends PHPUnit_Framework_TestCase
{
    public function testAndThenAsync()
    {
        $noOp = function () {
            // noop used as a fallback to missing trigger callbacks
        };

        $callbackTriggers = [ 'urlsLoaded' => $noOp, 'usersLoaded' => $noOp ];

        // function that pretends it loads a list of urls from somewhere
        $loadUrls = function () use (&$callbackTriggers) {
            return Eventually::unit(function ($success) use (&$callbackTriggers) {
                $callbackTriggers['urlsLoaded'] = function() use ($success) {
                    $success([ 'http://google.de', 'http://shrink.de' ]);
                };
            });
        };

        // function that pretends it loads a list of usernames from somewhere
        // it requires a list of urls to build on
        $loadUsers = function ($urls) use (&$callbackTriggers) {
            return Eventually::unit(function ($success) use (&$callbackTriggers) {
                $callbackTriggers['usersLoaded'] = function() use ($success) {
                    $success([ 'shrink0r', 'graste' ]);
                };
            });
        };

        $loadedUsers = [];
        // chain the loadUrls and loadUsers functions and do something with the users when they become available
        $eventually = $loadUrls()->bind($loadUsers)->get(function ($users) use (&$loadedUsers) {
            foreach ($users as $user) {
                $loadedUsers[] = $user;
            }
        });

        // simulate events firing later
        $callbackTriggers['urlsLoaded']();
        $callbackTriggers['usersLoaded']();

        $this->assertEquals([ 'shrink0r', 'graste' ], $loadedUsers);
    }

    public function testAndThenSync()
    {
        // function that immediately provides a list of urls from somewhere
        $loadUrls = function () {
            return Eventually::unit(function ($success) {
                $success([ 'http://google.de', 'http://shrink.de' ]);
            });
        };

        // function that immediately provides a list of usernames
        $loadUsers = function ($urls) {
            return Eventually::unit(function ($success) {
                $success([ 'shrink0r', 'graste' ]);
            });
        };

        $loadedUsers = [];
        // chain the loadUrls and loadUsers functions
        $eventually = $loadUrls()->bind($loadUsers)->get(function ($users) use (&$loadedUsers) {
            foreach ($users as $user) {
                $loadedUsers[] = $user;
            }
        });

        $expectedUsers = [ 'shrink0r', 'graste' ];
        $this->assertEquals($expectedUsers, $loadedUsers);
        $this->assertEquals($expectedUsers, $eventually->get());
    }
}
