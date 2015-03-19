<small>Shrink0r\Monatic</small>

MonadInterface
==============

Specifies the behavior, that must be provided by concrete monad implementations within &quot;monatic&quot;.

Signature
---------

- It is a(n) **interface**.

Methods
-------

The interface defines the following methods:

- [`unit()`](#unit) &mdash; Wrap the given value inside a specific MonadInterface implementation.
- [`get()`](#get) &mdash; Ununit the the value contained by a specific MonadInterface implementation.
- [`bind()`](#bind) &mdash; Process the given $codeBlock in the context of the contained value
and allow for continuation by returning a new monad instance.

### `unit()` <a name="unit"></a>

Wrap the given value inside a specific MonadInterface implementation.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$value` (`mixed`) &mdash; A value that is specific to a concrete monad.
- It returns a(n) [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) value.

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
    - `$codeBlock` (`callable`)
- It returns a(n) [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) value.

