<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exceptions\InvalidArgumentException;

/**
 * Class FloatValueObject
 *
 * Abstract base class for value objects representing a float.
 * Ensures the float value is valid and provides methods for accessing and comparing the value.
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
     * FloatValueObject constructor.
     *
     * @param float $value The float value.
     *
     * @throws InvalidArgumentException If the provided value is not valid.
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
        $min = $min ?? PHP_FLOAT_MIN;
        $max = $max ?? PHP_FLOAT_MAX;
        $decimals = $decimals ?? 2; // Default max decimals

        if ($value < $min || $value > $max) {
            throw new InvalidArgumentException(sprintf('Value "%s" is out of range [%s, %s]', $value, $min, $max));
        }

        $parts = explode('.', (string) $value);
        if (isset($parts[1]) && strlen($parts[1]) > $decimals) {
            throw new InvalidArgumentException(sprintf('Value "%s" has more than %s decimals', $value, $decimals));
        }
    }

    /**
     * Gets the value of the object as a float.
     *
     * @return float The float value of the object.
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
     * Named constructor for FloatValueObject
     *
     * @param float $value
     * @param float|null $min
     * @param float|null $max
     * @param int|null $decimals
     * @return static
     * @throws InvalidArgumentException
     */
    public static function doCreate(float $value, ?float $min = null, ?float $max = null, ?int $decimals = null): static
    {
        return new static($value, $min, $max, $decimals);
    }

    /**
     * Static method to generate a random float within min and max values with max decimals.
     *
     * @param float|null $min
     * @param float|null $max
     * @param int|null $decimals
     * @return static
     * @throws InvalidArgumentException
     */
    public static function generate(): static
    {
        // Verificar si la clase heredera tiene las constantes definidas
        $min = defined('static::MIN') ? static::MIN : 0.0;
        $max = defined('static::MAX') ? static::MAX : 100.0;
        $decimals = defined('MAX_DECIMALS') ? static::MAX_DECIMALS : 2;

        if ($min >= $max) {
            throw new InvalidArgumentException('Min must be less than Max.');
        }

        // Generar número flotante aleatorio
        $factor = pow(10, $decimals);
        $randomFloat = mt_rand((int)($min * $factor), (int)($max * $factor)) / $factor;

        // Crear una instancia de la clase hija
        return static::doCreate($randomFloat, $min, $max, $decimals);
    }

}
