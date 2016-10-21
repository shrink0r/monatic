<?php

namespace Shrink0r\Monatic\Tests;

use Shrink0r\Monatic\Many;
use Shrink0r\Monatic\Maybe;
use Shrink0r\Monatic\ManyMaybe;
use PHPUnit_Framework_TestCase;

class ManyMaybeTest extends PHPUnit_Framework_TestCase
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

        $titleWords = ManyMaybe::unit($blogs)->categories->articles->bind(function ($optArticle) {
            return ManyMaybe::unit(explode(' ', $optArticle->title->get()));
        });
        $this->assertEquals($expectedWords, $titleWords->get());

        $titleWords = ManyMaybe::unit($blogs)->categories->articles->title->bind(function ($optTitle) {
            return ManyMaybe::unit(explode(' ', $optTitle->get()));
        });
        $this->assertEquals($expectedWords, $titleWords->get());
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

        $titleWords = ManyMaybe::unit($blogs)->categories->articles->bind(function ($optArticle) {
            return ManyMaybe::unit(explode(' ', $optArticle->title->get()));
        });

        $this->assertEquals([], $titleWords->get());
    }
}
