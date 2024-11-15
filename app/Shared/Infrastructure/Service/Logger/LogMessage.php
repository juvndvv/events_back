<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Logger;

readonly class LogMessage
{
    protected function __construct(
        private LogLevel $level,
        private string   $environment,
        private string   $application,
        private string   $context,
        private string   $message,
    ) {
    }

    public function getAppName(): string
    {
        return $this->application;
    }

    public function getLevel(): LogLevel
    {
        return $this->level;
    }

    public function getLog(): array
    {
        return [
            'level' => $this->level,
            'environment' => $this->environment,
            'application' => $this->application,
            'context' => $this->context,
            'message' => $this->message,
        ];
    }

    public function __toString(): string
    {
        return sprintf(
            '[%s] %s.%s in %s: %s',
            $this->level->toString(),
            $this->application,
            $this->environment,
            $this->context,
            $this->message
        );
    }


    public static function create(
        LogLevel $level,
        string   $environment,
        string   $application,
        string   $context,
        string   $message
    ): self {
        return new self($level, $environment, $application, $context, $message);
    }
}
