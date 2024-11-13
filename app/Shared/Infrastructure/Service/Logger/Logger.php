<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Logger;

interface Logger
{
    public function debug(string $message): void;
    public function info(string $message): void;
    public function warning(string $message): void;
    public function error(string $message): void;
    public function critical(string $message): void;
}
