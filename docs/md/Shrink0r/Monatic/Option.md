<small>Shrink0r\Monatic</small>

Option
======

Wraps a given value, thereby providing fluent access to it&#039;s underlying properties.

Signature
---------

- It is a(n) **class**.
- It implements the [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) interface.

Methods
-------

The class defines the following methods:

- [`wrap()`](#wrap) &mdash; Wraps the given value inside a new Option instance.
- [`unwrap()`](#unwrap) &mdash; Unwraps the Option&#039;s value and applies the optional $codeBlock before returning it.
- [`andThen()`](#andThen) &mdash; Runs the given $codeBlock on the Option&#039;s value, if the value isn&#039;t null.
- [`__get()`](#__get) &mdash; Retrieves the Option value for the underlying property by name.

### `wrap()` <a name="wrap"></a>

Wraps the given value inside a new Option instance.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$value` (`mixed`) &mdash; A value that is specific to a concrete monad.
- _Returns:_ Returns None if the given value is null.
    - [`Option`](../../Shrink0r/Monatic/Option.md)

### `unwrap()` <a name="unwrap"></a>

Unwraps the Option&#039;s value and applies the optional $codeBlock before returning it.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) `mixed` value.

### `andThen()` <a name="andThen"></a>

Runs the given $codeBlock on the Option&#039;s value, if the value isn&#039;t null.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`) &mdash; Is expected to return the next value to be wrapped.
- _Returns:_ Returns None if the next value is null.
    - [`Option`](../../Shrink0r/Monatic/Option.md)

### `__get()` <a name="__get"></a>

Retrieves the Option value for the underlying property by name.

#### Description

This adds syntatic sugar to the Option monad, allowing to chain property/array access.
Example: Option::wrap($arr)-&gt;keyone-&gt;keytwo-&gt;etc-&gt;unwrap();

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$propertyName` (`string`)
- _Returns:_ Returns None if the property/key doesn&#039;t exist or equals null.
    - [`Option`](../../Shrink0r/Monatic/Option.md)

