<small>Shrink0r\Monatic</small>

Eventually
==========

Wraps a given callable, which will eventually invoke a given success callback, when it can provide a value.

Description
-----------

Basically this allows to chain async calls in a straight line without nesting callbacks.

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

### `unit()` <a name="unit"></a>

Wrap the given value inside a specific MonadInterface implementation.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) [`Eventually`](../../Shrink0r/Monatic/Eventually.md) value.

### `get()` <a name="get"></a>

Ununit the the value contained by a specific MonadInterface implementation.

#### Description

In most cases the optonal $codeBlock allows to directly manipulate the value during retrieval.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- _Returns:_ Returns an instance of Eventually, if the value wasn&#039;t available yet.
    - `mixed`

### `bind()` <a name="bind"></a>

Process the given $codeBlock in the context of the contained value
and allow for continuation by returning a new monad instance.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`) &mdash; Is expected to return an instance of Eventually.
- It returns a(n) [`Eventually`](../../Shrink0r/Monatic/Eventually.md) value.

