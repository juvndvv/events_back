<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Logger;

enum LogLevel
{
    case DEBUG;
    case INFO;
    case WARNING;
    case ERROR;
    case CRITICAL;

    public function toString(): string
    {
        return match($this) {
            self::DEBUG => 'DEBUG',
            self::INFO => 'INFO',
            self::WARNING => 'WARNING',
            self::ERROR => 'ERROR',
            self::CRITICAL => 'CRITICAL',
        };
    }
}
