<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;


use App\Shared\Domain\Exception\InvalidArgumentException;

/**
 * Class FloatValueObject
 *
 * Abstract base class for value objects representing a float.
 * Ensures the integer value is valid and provides methods for accessing and comparing the value.
 *
 * @package App\Shared\Domain\ValueObject
 */
abstract class FloatValueObject
{
    /**
     * @var float The float value of the value object.
     */
    protected float $value;

    /**
     * IntegerValueObject constructor.
     *
     * @param float $value The integer value.
     *
     * @throws InvalidArgumentException If the provided value is not a valid integer.
     */
    private function __construct(float $value, ?float $min = null, ?float $max = null, ?int $decimals = null)
    {
        $this->ensureIsValid($value, $min, $max, $decimals);
        $this->value = $value;
    }

    /**
     * Ensures that the value is valid.
     *
     * This method can be overridden by subclasses to provide specific validation rules.
     *
     * @param float $value The value to validate.
     *
     * @throws InvalidArgumentException
     */
    protected function ensureIsValid(float $value, ?float $min, ?float $max, ?int $decimals): void
    {
        if ($value <= $min ?? PHP_FLOAT_MIN || $value >= $max ?? PHP_FLOAT_MAX) {
            throw new InvalidArgumentException(sprintf('Value "%s" is out of range [%s, %s]', $value, $min, $max));
        }

        $parts = explode('.', (string) $value);
        if (isset($parts[1]) && strlen($parts[1]) > 2) {
            throw new InvalidArgumentException(sprintf('Value "%s" has more than %s decimals [%s]', $decimals, $value));
        }
    }

    /**
     * Gets the value of the object as an integer.
     *
     * @return float The integer value of the object.
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * Converts the object to a string.
     *
     * @return string The string representation of the object.
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * Checks if two value objects are equal.
     *
     * @param FloatValueObject $other The other value object to compare.
     *
     * @return bool True if both value objects have the same value, false otherwise.
     */
    public function equals(FloatValueObject $other): bool
    {
        return $this->value === $other->value();
    }

    /**
     * Named constructor for StringValueObject
     *
     * @param float $value
     * @param int|null $min
     * @param int|null $max
     * @return FloatValueObject
     * @throws InvalidArgumentException
     */
    public static function doCreate(float $value, ?int $min = null, ?int $max = null, int $decimals = null): static
    {
        return new static($value, $min, $max, $decimals);
    }
}
