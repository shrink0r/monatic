<small>Shrink0r\Monatic</small>

ManyOption
==========

Special subtype of the Many monad that wraps it&#039;s array-elements into Option values.

Signature
---------

- It is a(n) **class**.
- It is a subclass of [`Many`](../../Shrink0r/Monatic/Many.md).

Methods
-------

The class defines the following methods:

- [`unwrap()`](#unwrap) &mdash; Unwraps the contained array and applies the optional $codeBlock to each element before returning it.

### `unwrap()` <a name="unwrap"></a>

Unwraps the contained array and applies the optional $codeBlock to each element before returning it.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) `array` value.

