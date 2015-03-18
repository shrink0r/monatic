<?php

namespace Shrink0r\Monatic\Tests\Fixtures;

class Article
{
    protected $title;

    protected $text;

    public function __construct($title, $text)
    {
        $this->title = $title;
        $this->text = $text;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }
}
