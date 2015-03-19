<?php

namespace Shrink0r\Monatic;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Wraps a given collection, thereby providing recursive/fluent access to any underlying collections.
 */
class Many extends Monad
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
     * @return Maybe Returns None if the given value is null.
     */
    public static function unit($values)
    {
        return new static(empty($values) ? [] : (is_array($values) ? $values : [ $values ]));
    }

    /**
     * Returns the contained array and applies the optional $codeBlock to each element before returning it.
     *
     * @param callable $codeBlock
     *
     * @return array
     */
    public function get(callable $codeBlock = null)
    {
        if (is_callable($codeBlock)) {
            return array_map($codeBlock, $this->values);
        } else {
            return $this->values;
        }
    }

    /**
     * Maps the given $codeBlock to each element of the contained array
     * and units the flattened result in a new Many instance.
     *
     * @param callable $codeBlock
     *
     * @return Many
     */
    public function bind(callable $codeBlock)
    {
        return static::unit(array_reduce(array_map($codeBlock, $this->values), [ $this, 'flatMap' ], []));
    }

    /**
     * Retrieves the Many value for the underlying collection-property by name.
     *
     * This allows to chain recursive collection access.
     * Example: Many::unit($arr)->collection1_1->collection1_2->someKey->get();
     * Will return all the values for "someKey" found within the elements of collection1_2,
     * that are contained within the elements of collection1_1.
     *
     * @param string $propertyName
     *
     * @return Maybe Returns None if the property/key doesn't exist or equals null.
     */
    public function __get($propertyName)
    {
        return $this->bind(function ($value) use ($propertyName) {
            return static::unit($this->accessValue($value, $propertyName));
        });
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
     * If the given $context is an Maybe, the getped result of the value-access is returned.
     *
     * @param mixed $context The context to retrieve the value from.
     * @param string $key The property-name/array-key to use in order to read the value from the $context.
     *
     * @return mixed
     */
    protected function accessValue($context, $key)
    {
        if ($context instanceof Maybe) {
            return $context->$key->get();
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
        $getped = $result->get();

        if (!is_array($getped)) {
            $getped = [ $getped ];
        }

        return array_merge($flattened, $getped);
    }

    /**
     * call an arbitrary method on the unitped value
     * and unit the result again.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return MonadInterface
     */
    public function __call($name, array $arguments)
    {
        return $this->bind(function($value) use ($name, $arguments) {
            return static::unit(
                call_user_func([$value, $name], $arguments)
            );
        });
    }
}
