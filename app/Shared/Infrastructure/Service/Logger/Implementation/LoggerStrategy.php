<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Logger\Implementation;


use App\Shared\Infrastructure\Service\Logger\LogLevel;
use App\Shared\Infrastructure\Service\Logger\LogMessage;

interface LoggerStrategy
{
    public function log(LogMessage $message): void;
    /**
     * @param LogLevel $level
     * @return array<LogLevel>
     */
    public function supports(LogLevel $level): array;
}
