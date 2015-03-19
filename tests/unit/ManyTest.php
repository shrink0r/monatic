<?php

namespace Shrink0r\Monatic\Tests;

use Shrink0r\Monatic\Many;
use Shrink0r\Monatic\Option;
use Shrink0r\Monatic\Tests\Fixtures\Article;
use Shrink0r\Monatic\Tests\Fixtures\Category;
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

    public function testCallChainValid()
    {
        $article1 = new Article('monads hurray 1', '', ['one', 'two']);
        $article2 = new Article('monads hurray 2', '', ['foo', 'bar']);
        $category = new Category('programming', [ $article1, $article2 ]);

        $tags = Many::wrap($category)->getArticles()->getTags();

        $this->assertEquals(['one', 'two', 'foo', 'bar'], $tags->unwrap());
    }

    public function testCallChainInvalid()
    {
        $article1 = new Article('monads hurray 1', '');
        $article2 = new Article('monads hurray 2', '');
        $category = new Category('programming', [ $article1, $article2 ]);

        $tags = Many::wrap($category)->getArticles()->getTags();

        $this->assertEquals([], $tags->unwrap());
    }
}
