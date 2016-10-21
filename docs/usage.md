# Brief usage examples

## Maybe

Chained access to nested array/object values:

```php
<?php

use Shrink0r\Monatic\Maybe;

$data = [ "foo" => [ "bar" => "hello world!"] ];

echo Maybe::unit($data)->foo->bar->get();
// > hello world!

echo Maybe::unit($data)->foo->snafu->get();
// > (null)

echo get_class(Maybe::unit($data)->foo->snafu);
// > Shrink0r\Monatic\None

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

echo implode(', ', Many::unit($data)->categories->articles->title->get());
// > foo one text, foo two text, foo three text, foo four text

echo implode(', ', Many::unit($data)->snafu->articles->title->get());
// > (empty string)

?>
```

## ManyMaybe

Similar to ```Many```. The difference is, that the ```$value```, that is passed to ```bind```'s callback is guaranteed to be a ```Maybe``` monad:

```php
<?php

use Shrink0r\Monatic\ManyMaybe;
use Shrink0r\Monatic\Maybe;

$data = [
    // ... same definition as in the Many example
];

$titleWords = ManyMaybe::unit($data)->categories->articles->bind(function (Maybe $article) {
    // instead of relying on $article['title'] we can now use $article->title
    return ManyMaybe::unit(explode(' ', $article->title->get()));
});

echo implode(', ', array_unique($titleWords->get()));
// > foo, one, text, two, three, four

?>
```

## Attempt

Chained execution of dependent method invocations that might throw an exception.
In case an exception is raised along the way, then an Error is returned in the end.

```php
<?php

use Shrink0r\Monatic\Attempt;

// Success case example:
$loadInitialData = function (Success $result) {
    return [ 'php', 'python' ];
};
$loadMoreData = function (Success $result) {
    return array_merge($result->get(), [ 'ruby', 'rust', 'erlang' ]);
};

$result = Attempt::unit($loadInitialData)->bind($loadMoreData)->get();
echo implode(", ", $result->get()); // $result is a Success monad
// > php, python, ruby, rust, erlang


// Error case example:
$loadInitialData = function (Success $result) {
    throw new Exception("An error occured!");
};
$loadMoreData = function (Success $result) {
    return array_merge($result->get(), [ 'ruby', 'rust', 'erlang' ]);
};

$result = Attempt::unit($loadInitialData)->bind($loadMoreData)->get();
echo $result->get()->getMessage(); // $result is an Error monad
// > An error occured!

?>
```

## Eventually

Chained execution of dependent method invocations that might execute asynchronously:

```php
<?php

use Shrink0r\Monatic\Eventually;

$loadInitialData = function () {
    return Eventually::unit(function ($success) {
        $success([ 'php', 'python' ]);
    });
};

$loadMoreData = function ($initialData) {
    return Eventually::unit(function ($success) use ($initialData) {
        // this is where you would call your async code and pass it along the $success callback
        $success(array_merge($initialData, [ 'ruby', 'rust', 'erlang' ]));
    });
};

$eventually = $loadInitialData()->bind($loadMoreData)->get(function ($finalData) {
    echo implode(", ", $finalData);
});
// > php, python, ruby, rust, erlang

?>
```
