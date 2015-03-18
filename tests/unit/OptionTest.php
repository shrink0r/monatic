<?php

namespace Monatic\Tests;

use Monatic\Tests\Fixtures\Article;
use Monatic\Tests\Fixtures\Category;
use Monatic\Option;
use Monatic\None;
use PHPUnit_Framework_TestCase;

class OptionTest extends PHPUnit_Framework_TestCase
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

        $weather = Option::wrap($data)->creator->address->country->capital->weather;

        $this->assertEquals('sunny', $weather->unwrap());
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

        $weather = Option::wrap($data)->creator->address->country->capital->weather;

        $this->assertNull($weather->unwrap());
        $this->assertInstanceOf(None::CLASS, $weather);
    }

    public function testAndThenValidObject()
    {
        $article = new Article('monads hurray', 'I can haz monads and so can haz you!');
        $category = new Category('programming', [ $article ]);

        $title = Option::wrap($category)->firstArticle->title;

        $this->assertEquals($article->getTitle(), $title->unwrap());
    }

    public function testAndThenInvalidObject()
    {
        $category = new Category('programming');

        $title = Option::wrap($category)->firstArticle->title;

        $this->assertNull($title->unwrap());
        $this->assertInstanceOf(None::CLASS, $title);
    }
}
