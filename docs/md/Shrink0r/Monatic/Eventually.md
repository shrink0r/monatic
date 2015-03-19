<small>Shrink0r\Monatic</small>

Eventually
==========

Wraps a given callable, which will eventually invoke a given success callback, when it can provide a value.

Description
-----------

Basically this allows to chain async calls in a straight line, no callback nesting required.

Signature
---------

- It is a(n) **class**.
- It implements the [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) interface.

Methods
-------

The class defines the following methods:

- [`wrap()`](#wrap) &mdash; Wraps the given callable in a new Eventually instance.
- [`unwrap()`](#unwrap) &mdash; Eventually provides the unwrapped value.
- [`andThen()`](#andThen) &mdash; Invokes the given callable as soon as a value eventually becomes available.

### `wrap()` <a name="wrap"></a>

Wraps the given callable in a new Eventually instance.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) [`Eventually`](../../Shrink0r/Monatic/Eventually.md) value.

### `unwrap()` <a name="unwrap"></a>

Eventually provides the unwrapped value.

#### Description

If the value can not be provided at the moment,
a pointer to self is returned and the $codeBlock is executed when the value becomes available.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- _Returns:_ Returns an instance of Eventually, if the value wasn&#039;t available yet.
    - `mixed`

### `andThen()` <a name="andThen"></a>

Invokes the given callable as soon as a value eventually becomes available.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`) &mdash; Is expected to return an instance of Eventually.
- It returns a(n) [`Eventually`](../../Shrink0r/Monatic/Eventually.md) value.

