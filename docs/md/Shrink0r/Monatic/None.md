<small>Shrink0r\Monatic</small>

None
====

Acts as a null-value for the Maybe monad.

Signature
---------

- It is a(n) **class**.
- It is a subclass of [`Maybe`](../../Shrink0r/Monatic/Maybe.md).

Methods
-------

The class defines the following methods:

- [`__construct()`](#__construct) &mdash; Creates a new None monad.
- [`unit()`](#unit) &mdash; Wrap the given value inside a specific MonadInterface implementation.
- [`get()`](#get) &mdash; Ununit the the value contained by a specific MonadInterface implementation.

### `__construct()` <a name="__construct"></a>

Creates a new None monad.

#### Signature

- It is a **public** method.
- It does not return anything.

### `unit()` <a name="unit"></a>

Wrap the given value inside a specific MonadInterface implementation.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$value` (`mixed`) &mdash; A value that is specific to a concrete monad.
- _Returns:_ Returns None if the given value is null.
    - [`None`](../../Shrink0r/Monatic/None.md)

### `get()` <a name="get"></a>

Ununit the the value contained by a specific MonadInterface implementation.

#### Description

In most cases the optonal $codeBlock allows to directly manipulate the value during retrieval.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`) &mdash; Is never executed for this type.
- It returns a(n) `null` value.

