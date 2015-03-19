<small>Shrink0r\Monatic</small>

Many
====

Wraps a given array, thereby providing recursive+fluent access to any underlying collections.

Signature
---------

- It is a(n) **class**.
- It implements the [`MonadInterface`](../../Shrink0r/Monatic/MonadInterface.md) interface.

Methods
-------

The class defines the following methods:

- [`wrap()`](#wrap) &mdash; Wraps the given array/value inside a new Many instance.
- [`unwrap()`](#unwrap) &mdash; Unwraps the contained array and applies the optional $codeBlock to each element before returning it.
- [`andThen()`](#andThen) &mdash; Maps the given $codeBlock to each element of the contained array
and wraps the flattened result in a new Many instance.
- [`__get()`](#__get) &mdash; Retrieves the Many value for the underlying collection-property by name.

### `wrap()` <a name="wrap"></a>

Wraps the given array/value inside a new Many instance.

#### Signature

- It is a **public static** method.
- It accepts the following parameter(s):
    - `$values` (`mixed`) &mdash; If the value isn&#039;t an array, a new array is created from it.
- _Returns:_ Returns None if the given value is null.
    - [`Option`](../../Shrink0r/Monatic/Option.md)

### `unwrap()` <a name="unwrap"></a>

Unwraps the contained array and applies the optional $codeBlock to each element before returning it.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) `array` value.

### `andThen()` <a name="andThen"></a>

Maps the given $codeBlock to each element of the contained array
and wraps the flattened result in a new Many instance.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$codeBlock` (`callable`)
- It returns a(n) [`Many`](../../Shrink0r/Monatic/Many.md) value.

### `__get()` <a name="__get"></a>

Retrieves the Many value for the underlying collection-property by name.

#### Description

This allows to chain recursive collection access.
Example: Many::wrap($arr)-&gt;collection1_1-&gt;collection1_2-&gt;someKey-&gt;unwrap();
Will return all the values for &quot;someKey&quot; found within the elements of collection1_2,
that are contained within the elements of collection1_1.

#### Signature

- It is a **public** method.
- It accepts the following parameter(s):
    - `$propertyName` (`string`)
- _Returns:_ Returns None if the property/key doesn&#039;t exist or equals null.
    - [`Option`](../../Shrink0r/Monatic/Option.md)

