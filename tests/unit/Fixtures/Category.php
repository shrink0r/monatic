<?php

namespace Shrink0r\Monatic\Tests\Fixtures;

class Category
{
    protected $name;

    protected $articles;

    public function __construct($name, array $articles = [])
    {
        $this->name = $name;
        $this->articles = $articles;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFirstArticle()
    {
        return reset($this->articles) ?: null;
    }
}
