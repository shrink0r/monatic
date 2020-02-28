<?php

namespace Shrink0r\Monatic\Tests;

use Shrink0r\Monatic\Tests\Fixtures\Article;
use Shrink0r\Monatic\Tests\Fixtures\Category;
use Shrink0r\Monatic\Maybe;
use Shrink0r\Monatic\None;

class MaybeTest extends TestCase
{
    public function testAndThenValid()
    {
        $data = [
            'creator' => [
                'address' => [
                    'country' => [
                        'capital' => [
                            'weather' => 'sunny'
                        ]
                    ]
                ]
            ]
        ];

        $weather = Maybe::unit($data)->creator->address->country->capital->weather;

        $this->assertEquals('sunny', $weather->get());
    }

    public function testAndThenInvalid()
    {
        $data = [
            'creator' => [
                'address' => [
                    'country' => [
                        'capistal' => [ // <- non-existant/invalid key used here
                            'weather' => 'sunny'
                        ]
                    ]
                ]
            ]
        ];

        $weather = Maybe::unit($data)->creator->address->country->capital->weather;

        $this->assertNull($weather->get());
        $this->assertInstanceOf(None::CLASS, $weather);
    }

    public function testAndThenValidObject()
    {
        $article = new Article('monads hurray', 'I can haz monads and so can haz you!');
        $category = new Category('programming', [ $article ]);

        $title = Maybe::unit($category)->firstArticle->title;

        $this->assertEquals($article->getTitle(), $title->get());
    }

    public function testAndThenInvalidObject()
    {
        $category = new Category('programming');

        $title = Maybe::unit($category)->firstArticle->title;

        $this->assertNull($title->get());
        $this->assertInstanceOf(None::CLASS, $title);
    }

    public function testCallChainValid()
    {
        $article = new Article('monads hurray', 'I can haz monads and so can haz you!');
        $category = new Category('programming', [ $article ]);

        $title = Maybe::unit($category)->getFirstArticle()->getTitle();

        $this->assertEquals($article->getTitle(), $title->get());
    }

    public function testCallChainInvalid()
    {
        $category = new Category('programming', [ ]);

        $title = Maybe::unit($category)->getFirstArticle()->getTitle();

        $this->assertInstanceOf(None::CLASS, $title);
    }
}
