<?php

namespace Shrink0r\Monatic\Tests\Fixtures;

class Article
{
    protected $title;

    protected $text;

    public function __construct($title, $text, array $tags = [])
    {
        $this->title = $title;
        $this->text = $text;
        $this->tags = $tags;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getTags()
    {
        return $this->tags;
    }
}
