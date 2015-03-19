<small>Shrink0r\Monatic</small>

None
====

Acts as a null-object for the Option monad.

Signature
---------

- It is a(n) **class**.
- It is a subclass of [`Option`](../../Shrink0r/Monatic/Option.md).

Methods
-------

The class defines the following methods:

- [`__construct()`](#__construct) &mdash; Creates a new None instance.
- [`wrap()`](#wrap) &mdash; Wraps the given value inside a new None instance, effectively nulling the value.
- [`unwrap()`](#unwrap) &mdash; Unwraps the None instance&#039;s (null)value.

### `__construct()` <a name="__construct"></a>

Creates a new None instance.

#### Signature

- It is a **public** method.
- It does not return anything.

### `wrap()` <a name="wrap"></a>

Wraps the given value inside a new None instance, effectively nulling the value.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$value` (`mixed`) &mdash; A value that is specific to a concrete monad.
- _Returns:_ Returns None if the given value is null.
    - [`None`](../../Shrink0r/Monatic/None.md)

### `unwrap()` <a name="unwrap"></a>

Unwraps the None instance&#039;s (null)value.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`) &mdash; Is never executed for this type.
- It returns a(n) `null` value.

