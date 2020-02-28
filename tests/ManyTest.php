<?php

namespace Shrink0r\Monatic\Tests;

use Shrink0r\Monatic\Many;
use Shrink0r\Monatic\Tests\Fixtures\Article;
use Shrink0r\Monatic\Tests\Fixtures\Category;

class ManyTest extends TestCase
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

        $titleWords = Many::unit($blogs)->categories->articles->bind(function ($article) {
            return Many::unit(explode(' ', $article['title']));
        });
        $this->assertEquals($expectedWords, $titleWords->get());

        $titleWords = Many::unit($blogs)->categories->articles->title->bind(function ($title) {
            return Many::unit(explode(' ', $title));
        });
        $this->assertEquals($expectedWords, $titleWords->get());
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

        $titleWords = Many::unit($blogs)->categories->articles->bind(function ($article) {
            return Many::unit(explode(' ', $article['title']));
        });

        $this->assertEquals([], $titleWords->get());
    }

    public function testCallChainValid()
    {
        $article1 = new Article('monads hurray 1', '', ['one', 'two']);
        $article2 = new Article('monads hurray 2', '', ['foo', 'bar']);
        $category = new Category('programming', [ $article1, $article2 ]);

        $tags = Many::unit($category)->getArticles()->getTags();

        $this->assertEquals(['one', 'two', 'foo', 'bar'], $tags->get());
    }

    public function testCallChainInvalid()
    {
        $article1 = new Article('monads hurray 1', '');
        $article2 = new Article('monads hurray 2', '');
        $category = new Category('programming', [ $article1, $article2 ]);

        $tags = Many::unit($category)->getArticles()->getTags();

        $this->assertEquals([], $tags->get());
    }
}
