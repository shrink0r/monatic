<small>Shrink0r\Monatic</small>

Maybe
=====

Wraps a given value and provides fluent access to it&#039;s underlying properties.

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
- [`__get()`](#__get) &mdash; Retrieves the monad&#039;s value for the underlying property by name.
- [`__call()`](#__call) &mdash; Calls an arbitrary method on the monad&#039;s value and returns a monad with the result.

### `unit()` <a name="unit"></a>

Wrap the given value inside a specific MonadInterface implementation.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$value` (`mixed`) &mdash; A value that is specific to a concrete monad.
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
- It returns a(n) `mixed` value.

### `bind()` <a name="bind"></a>

Process the given $codeBlock in the context of the contained value
and allow for continuation by returning a new monad instance.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`) &mdash; Is expected to return the next value to be unitped.
- _Returns:_ Returns None if the next value is null.
    - [`Maybe`](../../Shrink0r/Monatic/Maybe.md)

### `__get()` <a name="__get"></a>

Retrieves the monad&#039;s value for the underlying property by name.

#### Description

This adds syntatic sugar to the Maybe monad, allowing to chain property/array access.
Example: Maybe::unit($arr)-&gt;keyone-&gt;keytwo-&gt;etc-&gt;get();

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$propertyName` (`string`)
- _Returns:_ Returns None if the property/key doesn&#039;t exist or equals null.
    - [`Maybe`](../../Shrink0r/Monatic/Maybe.md)

### `__call()` <a name="__call"></a>

Calls an arbitrary method on the monad&#039;s value and returns a monad with the result.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$methodName`
    - `$arguments` (`array`)
- It returns a(n) [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) value.

