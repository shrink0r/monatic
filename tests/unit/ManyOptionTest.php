<?php

namespace Monatic\Tests;

use Monatic\Many;
use Monatic\Option;
use Monatic\ManyOption;
use PHPUnit_Framework_TestCase;

class ManyOptionTest extends PHPUnit_Framework_TestCase
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

        $titleWords = ManyOption::wrap($blogs)->categories->articles->andThen(
            function ($optArticle) {
                return ManyOption::wrap(explode(' ', $optArticle->title->unwrap()));
            }
        );
        $this->assertEquals($expectedWords, $titleWords->unwrap());

        $titleWords = ManyOption::wrap($blogs)->categories->articles->title->andThen(
            function ($optTitle) {
                return ManyOption::wrap(explode(' ', $optTitle->unwrap()));
            }
        );
        $this->assertEquals($expectedWords, $titleWords->unwrap());
    }

    public function stestAndThenInvalid()
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

        $titleWords = ManyOption::wrap($blogs)->categories->articles->andThen(
            function ($optArticle) {
                return ManyOption::wrap(explode(' ', $optArticle->title->unwrap()));
            }
        );

        $this->assertEquals([], $titleWords->unwrap());
    }
}
