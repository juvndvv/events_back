<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Logger\Implementation\Laravel;


use App\Shared\Infrastructure\Service\Logger\Implementation\LoggerStrategy;
use App\Shared\Infrastructure\Service\Logger\LogLevel;
use App\Shared\Infrastructure\Service\Logger\LogMessage;

class LaravelLogger implements LoggerStrategy
{
    public function log(LogMessage $message): void
    {
    }

    public function supports(LogLevel $level): array
    {
        return [
            LogLevel::DEBUG,
            LogLevel::INFO,
            LogLevel::WARNING,
            LogLevel::ERROR,
            LogLevel::CRITICAL,
        ];
    }
}
