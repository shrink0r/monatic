<?php

namespace Shrink0r\Monatic;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Wraps a given array, thereby providing recursive+fluent access to any underlying collections.
 */
class Many implements MonadInterface
{
    /**
     * @var array $values
     */
    private $values;

    /**
     * @var PropertyAccess $accessor
     */
    private $accessor;

    /**
     * Wraps the given array/value inside a new Many instance.
     *
     * @param mixed $values If the value isn't an array, a new array is created from it.
     *
     * @return Option Returns None if the given value is null.
     */
    public static function wrap($values)
    {
        return new static(empty($values) ? [] : (is_array($values) ? $values : [ $values ]));
    }

    /**
     * Unwraps the contained array and applies the optional $codeBlock to each element before returning it.
     *
     * @param callable $codeBlock
     *
     * @return array
     */
    public function unwrap(callable $codeBlock = null)
    {
        if (is_callable($codeBlock)) {
            return array_map($codeBlock, $this->values);
        } else {
            return $this->values;
        }
    }

    /**
     * Maps the given $codeBlock to each element of the contained array
     * and wraps the flattened result in a new Many instance.
     *
     * @param callable $codeBlock
     *
     * @return Many
     */
    public function andThen(callable $codeBlock)
    {
        return static::wrap(
            array_reduce(array_map($codeBlock, $this->values), [ $this, 'flatMap' ], [])
        );
    }

    /**
     * Retrieves the Many value for the underlying collection-property by name.
     *
     * This allows to chain recursive collection access.
     * Example: Many::wrap($arr)->collection1_1->collection1_2->someKey->unwrap();
     * Will return all the values for "someKey" found within the elements of collection1_2,
     * that are contained within the elements of collection1_1.
     *
     * @param string $propertyName
     *
     * @return Option Returns None if the property/key doesn't exist or equals null.
     */
    public function __get($propertyName)
    {
        return $this->andThen(
            function ($value) use ($propertyName) {
                return static::wrap($this->accessValue($value, $propertyName));
            }
        );
    }

    /**
     * Creates a new Many instance from the given array.
     *
     * @param array $values
     */
    protected function __construct(array $values)
    {
        $this->values = $values;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Internal helper method that is used to retrieve an underlying value from a given option/array/object.
     * If the given $context is scalar, it is returned as it was given.
     * If the given $context is an Option, the unwrapped result of the value-access is returned.
     *
     * @param mixed $context The context to retrieve the value from.
     * @param string $key The property-name/array-key to use in order to read the value from the $context.
     *
     * @return mixed
     */
    protected function accessValue($context, $key)
    {
        if ($context instanceof Option) {
            return $context->$key->unwrap();
        } elseif (is_array($context)) {
            return $this->accessor->getValue($context, "[{$key}]");
        } elseif (is_object($context)) {
            return $this->accessor->getValue($context, $key);
        } else {
            return $context;
        }
    }

    /**
     * Internal callback that is used in conjunction with php's array_reduce to flatten recursive chain results.
     *
     * @param array $flattened The current flat array.
     * @param MonadInterface $result The result to be reduced into the flat array.
     *
     * @return array A new flat array created from merging in the flattened result.
     */
    protected function flatMap(array $flattened, MonadInterface $result)
    {
        $unwrapped = $result->unwrap();

        if (!is_array($unwrapped)) {
            $unwrapped = [ $unwrapped ];
        }

        return array_merge($flattened, $unwrapped);
    }
}
