<small>Shrink0r\Monatic</small>

MonadInterface
==============

Specifies the behavior to be exposed by concrete monad implementations within &quot;monatic&quot;.

Description
-----------

Wtf is a monad?
https://en.wikipedia.org/wiki/Monad_(functional_programming)

Signature
---------

- It is a(n) **interface**.

Methods
-------

The interface defines the following methods:

- [`wrap()`](#wrap) &mdash; Wrap the given value inside a specific MonadInterface implementation.
- [`unwrap()`](#unwrap) &mdash; Unwrap the the value contained by a specific MonadInterface implementation.
- [`andThen()`](#andThen) &mdash; Process the given $codeBlock in the context of the contained value
and allow for continuation by returning a new monad instance.

### `wrap()` <a name="wrap"></a>

Wrap the given value inside a specific MonadInterface implementation.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$value` (`mixed`) &mdash; A value that is specific to a concrete monad.
- It returns a(n) [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) value.

### `unwrap()` <a name="unwrap"></a>

Unwrap the the value contained by a specific MonadInterface implementation.

#### Description

In most cases the optonal $codeBlock allows to directly manipulate the value during retrieval.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) `mixed` value.

### `andThen()` <a name="andThen"></a>

Process the given $codeBlock in the context of the contained value
and allow for continuation by returning a new monad instance.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) value.

