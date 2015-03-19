<small>Shrink0r\Monatic</small>

ManyMaybe
=========

Special subtype of the Many monad, that composes it&#039;s collection-items into Maybe monads.

Signature
---------

- It is a(n) **class**.
- It is a subclass of [`Many`](../../Shrink0r/Monatic/Many.md).

Methods
-------

The class defines the following methods:

- [`get()`](#get) &mdash; Ununit the the value contained by a specific MonadInterface implementation.

### `get()` <a name="get"></a>

Ununit the the value contained by a specific MonadInterface implementation.

#### Description

In most cases the optonal $codeBlock allows to directly manipulate the value during retrieval.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) `array` value.

