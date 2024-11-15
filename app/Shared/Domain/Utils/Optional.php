<?php

declare(strict_types=1);

namespace App\Shared\Domain\Utils;

use App\Shared\Domain\Exception\AppException;

/**
 * Abstract class `Optional`
 *
 * This class is a generic abstraction for handling optional values, similar to the Optional class found in languages like Java.
 * It provides mechanisms for safely handling and transforming values that may or may not be present, without resorting to null checks.
 *
 * The concrete type of the value is determined by implementing classes, which specify the type using the `getType` method.
 *
 * @template T The type of the value that might be present.
 */
abstract class Optional
{
    /**
     * @var T|null The value that might be present.
     */
    private mixed $value;

    /**
     * @var bool Whether a value is present.
     */
    private bool $isPresent;

    /**
     * Constructor.
     *
     * Initializes the optional with the given value. If the value is null, the optional will be considered empty.
     *
     * @param T|null $value The value that might be present, or null.
     * @throws \InvalidArgumentException If the value does not match the expected type.
     */
    public function __construct(mixed $value = null)
    {
        Assert::instanceOf(static::getType(), $value, nullable: true);

        $this->isPresent = $value !== null;
        $this->value = $value;
    }

    /**
     * Checks if a value is present.
     *
     * @return bool True if a value is present, false otherwise.
     */
    public function isPresent(): bool
    {
        return $this->isPresent;
    }

    /**
     * Retrieves the value if present, otherwise throws an exception.
     *
     * @return T The value that is present.
     * @throws AppException If no value is present.
     */
    public function get()
    {
        if (!$this->isPresent()) {
            throw new AppException("No value present");
        }

        return $this->value;
    }

    /**
     * Retrieves the value if present, otherwise returns the provided default value.
     *
     * @param T $other The default value to return if no value is present.
     * @return T The value if present, or the default value if not.
     * @throws \InvalidArgumentException If the default value does not match the expected type.
     */
    public function orElse(mixed $other)
    {
        Assert::instanceOf(static::getType(), $other);

        if (!$this->isPresent()) {
            return $other;
        }

        return $this->value;
    }

    public function orElseNull()
    {
        if (!$this->isPresent()) {
            return null;
        }

        return $this->value;
    }

    /**
     * Retrieves the value if present, otherwise throws an exception supplied by the provided function.
     *
     * @param callable(): \Throwable $exceptionSupplier A function that supplies the exception to throw if no value is present.
     * @return T The value if present.
     * @throws \Throwable The exception provided by the exception supplier if no value is present.
     */
    public function orElseThrow(callable $exceptionSupplier)
    {
        if (!$this->isPresent()) {
            throw $exceptionSupplier();
        }

        return $this->value;
    }

    /**
     * Executes the given consumer function if a value is present.
     *
     * @param callable(T):void $consumer A function to consume the value if present.
     */
    public function ifPresent(callable $consumer): static
    {
        if ($this->isPresent()) {
            $consumer($this->value);
        }

        return $this;
    }

    public function ifNotPresent(callable $consumer): static
    {
        if (!$this->isPresent()) {
            $consumer($this->value);
        }

        return $this;
    }

    /**
     * Abstract method that must be implemented by child classes to specify the expected type of the value.
     *
     * @return string The expected class or type of the value.
     */
    abstract public function getType(): string;

    /**
     * Factory method to create an Optional with a nullable value.
     *
     * @param T|null $value The value that might be present, or null.
     * @return static An Optional containing the value or empty if the value is null.
     */
    public static function ofNullable($value): static
    {
        return new static($value);
    }

    /**
     * Creates an Optional instance from a nullable value and a callable that creates the Value Object.
     *
     * @param mixed $value The value to be used to create the Value Object.
     * @param callable $creator A callable that creates the Value Object.
     * @return static<T> Returns an Optional containing the created Value Object, or an empty Optional if the value is null.
     */
    public static function ofNullableWith(mixed $value, callable $creator): static
    {
        if ($value === null) {
            return static::empty();
        }

        return static::ofNullable($creator($value));
    }

    /**
     * Factory method to create an empty Optional.
     *
     * @return static An empty Optional.
     */
    public static function empty(): static
    {
        return new static(null);
    }
}
