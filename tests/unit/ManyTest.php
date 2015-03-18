<?php

namespace Monatic\Tests;

use Monatic\Many;
use Monatic\Option;
use PHPUnit_Framework_TestCase;

class ManyTest extends PHPUnit_Framework_TestCase
{
    public function testAndThenValid()
    {
        $blogs = [
            [
                'categories' => [
                    [
                        'title' => 'foo category',
                        'articles' => [
                            [
                                'title' => 'article one',
                                'text' => 'article one text'
                            ],
                            [
                                'title' => 'article two',
                                'text' => 'article two text'
                            ]
                        ]
                    ],
                    [
                        'title' => 'bar category',
                        'articles' => [
                            [
                                'title' => 'article three',
                                'text' => 'article three text'
                            ],
                            [
                                'title' => 'article four',
                                'text' => 'article four text'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $expectedWords = [ 'article', 'one', 'article', 'two', 'article', 'three', 'article', 'four'];

        $titleWords = Many::wrap($blogs)->categories->articles->andThen(
            function ($article) {
                return Many::wrap(explode(' ', $article['title']));
            }
        );
        $this->assertEquals($expectedWords, $titleWords->unwrap());

        $titleWords = Many::wrap($blogs)->categories->articles->title->andThen(
            function ($title) {
                return Many::wrap(explode(' ', $title));
            }
        );
        $this->assertEquals($expectedWords, $titleWords->unwrap());
    }

    public function testAndThenInvalid()
    {
        $blogs = [
            [
                'categsories' => [ // <- key is misspelled here
                    [
                        'title' => 'foo category',
                        'articles' => [
                            [
                                'title' => 'article one',
                                'text' => 'article one text'
                            ],
                            [
                                'title' => 'article two',
                                'text' => 'article two text'
                            ]
                        ]
                    ],
                    [
                        'title' => 'bar category',
                        'articles' => [
                            [
                                'title' => 'article three',
                                'text' => 'article three text'
                            ],
                            [
                                'title' => 'article four',
                                'text' => 'article four text'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $titleWords = Many::wrap($blogs)->categories->articles->andThen(
            function ($article) {
                return Many::wrap(explode(' ', $article['title']));
            }
        );

        $this->assertEquals([], $titleWords->unwrap());
    }
}
