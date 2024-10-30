<?php

declare(strict_types=1);

namespace App\Shared\Domain\Utils;

use InvalidArgumentException;

final class Assert
{
    public static function arrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            self::instanceOf($class, $item);
        }
    }

    public static function instanceOf(string $class, mixed $item, bool $nullable = false): void
    {
        if ($nullable && $item === null) {
            return;
        }

        if (!$item instanceof $class) {
            throw new InvalidArgumentException(sprintf('The object <%s> is not an instance of <%s>', $item, $class));
        }
    }
}
