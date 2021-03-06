<small>Shrink0r\Monatic</small>

Many
====

Wraps a given collection, thereby providing recursive/fluent access to any underlying collections.

Signature
---------

- It is a(n) **class**.
- It implements the [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) interface.

Methods
-------

The class defines the following methods:

- [`unit()`](#unit) &mdash; Wrap the given value inside a specific MonadInterface implementation.
- [`get()`](#get) &mdash; Ununit the the value contained by a specific MonadInterface implementation.
- [`bind()`](#bind) &mdash; Process the given $codeBlock in the context of the contained value
and allow for continuation by returning a new monad instance.
- [`__get()`](#__get) &mdash; Retrieves the Many value for the underlying collection-property by name.
- [`__call()`](#__call) &mdash; Call an arbitrary method on the monad&#039;s value and return a new monad with the result.

### `unit()` <a name="unit"></a>

Wrap the given value inside a specific MonadInterface implementation.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$values` (`mixed`) &mdash; If the value isn&#039;t an array, a new array is created from it.
- _Returns:_ Returns None if the given value is null.
    - [`Maybe`](../../Shrink0r/Monatic/Maybe.md)

### `get()` <a name="get"></a>

Ununit the the value contained by a specific MonadInterface implementation.

#### Description

In most cases the optonal $codeBlock allows to directly manipulate the value during retrieval.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) `array` value.

### `bind()` <a name="bind"></a>

Process the given $codeBlock in the context of the contained value
and allow for continuation by returning a new monad instance.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) [`Many`](../../Shrink0r/Monatic/Many.md) value.

### `__get()` <a name="__get"></a>

Retrieves the Many value for the underlying collection-property by name.

#### Description

This allows to chain recursive collection access.
Example: Many::unit($arr)-&gt;collection1_1-&gt;collection1_2-&gt;someKey-&gt;get();
Will return all the values for &quot;someKey&quot; found within the elements of collection1_2,
that are contained within the elements of collection1_1.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$propertyName` (`string`)
- _Returns:_ Returns None if the property/key doesn&#039;t exist or equals null.
    - [`Maybe`](../../Shrink0r/Monatic/Maybe.md)

### `__call()` <a name="__call"></a>

Call an arbitrary method on the monad&#039;s value and return a new monad with the result.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$name` (`string`)
    - `$arguments` (`array`)
- It returns a(n) [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) value.

