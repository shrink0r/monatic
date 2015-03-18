# Monatic

[![Build Status](https://secure.travis-ci.org/shrink0r/monatic.png)](http://travis-ci.org/shrink0r/monatic)

Playing around with monads and php.

## Option

Chained access to nested array/object values:

```php
<?php

use Shrink0r\Monatic\Option;

$data = [ "foo" => [ "bar" => "hello world!"] ];

echo Option::wrap($data)->foo->bar->unwrap();
// > hello world!

echo Option::wrap($data)->foo->snafu->unwrap();
// > (null)

echo get_class(Option::wrap($data)->foo->snafu);
// > Shrink0r\\Monatic\\None

?>
```

## Many

Chained access across recursive collections:

```php
<?php

use Shrink0r\Monatic\Many;

$data = [
    [
        "categories" => [
            [
                "name" => "category-one",
                "articles" => [
                    [ "title" => "foo one text" ]
                ]
            ],
            [
                "name" => "category-two",
                "articles" => [
                    [ "title" => "foo two text" ]
                ]
            ]
        ]
    ],
    [
        "categories" => [
            [
                "name" => "category-three",
                "articles" => [
                    [ "title" => "foo three text" ]
                ]
            ],
            [
                "name" => "category-four",
                "articles" => [
                    [ "title" => "foo four text" ]
                ]
            ]
        ]
    ]
];

echo implode(', ', Many::wrap($data)->categories->articles->title->unwrap());
// > foo one text, foo two text, foo three text, foo four text

echo implode(', ', Many::wrap($data)->snafu->articles->title->unwrap());
// > (empty string)

?>
```

## ManyOption

Similar to ```Many```. The difference is, that the ```$value```, that is passed to ```andThen```'s callback is guaranteed to be an ```Option```:

```php
<?php

use Shrink0r\Monatic\ManyOption;
use Shrink0r\Monatic\Option;

$data = [
    // ... same definition as in the Many example
];

$allWordsInTitles = ManyOption::wrap($data)->categories->articles->andThen(
    function (Option $article) {
        return ManyOption::wrap(explode(' ', $article->title->unwrap()));
    }
);

echo implode(', ', array_unique($allWordsInTitles->unwrap()));
// > foo, one, text, two, three, four

?>
```

## Eventually

Chained execution of dependent method invocations that might execute asynchronously:

```php
<?php

use Shrink0r\Monatic\Eventually;

$loadInitialData = function () {
    return Eventually::wrap(
        function ($success) {
            $success([ 'php', 'python' ]);
        }
    );
};

$loadMoreData = function ($initialData) {
    return Eventually::wrap(
        function ($success) use ($initialData) {
            $success(
                array_merge($initialData, [ 'ruby', 'rust', 'erlang' ])
            );
        }
    );
};

$eventually = $loadInitialData()->andThen($loadMoreData)->unwrap(
    function ($finalData) {
        echo implode(", ", $finalData);
    }
);
// > php, python, ruby, rust, erlang

?>
```
