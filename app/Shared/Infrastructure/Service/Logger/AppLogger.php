<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Logger;


use App\Shared\Infrastructure\Service\Logger\Implementation\Laravel\LaravelLogger;
use App\Shared\Infrastructure\Service\Logger\Implementation\LoggerStrategy;
use App\Shared\Infrastructure\Service\Logger\Implementation\Slack\SlackLogger;

class AppLogger implements Logger
{
    /** @var array<LoggerStrategy> */
    private array $loggers;

    public function __construct(
        LaravelLogger $laravelLogger,
        SlackLogger $slackLogger,
    )
    {
        $this->loggers = [
            $laravelLogger,
            $slackLogger
        ];
    }

    public function debug(string $message): void
    {
        $this->log(LogLevel::DEBUG, $message);
    }

    public function info(string $message): void
    {
        $this->log(LogLevel::INFO, $message);
    }

    public function warning(string $message): void
    {
        $this->log(LogLevel::WARNING, $message);
    }

    public function error(string $message): void
    {
        $this->log(LogLevel::ERROR, $message);
    }

    public function critical(string $message): void
    {
        $this->log(LogLevel::CRITICAL, $message);
    }

    private function log(LogLevel $level, string $message): void
    {
        foreach ($this->loggers as $logger) {
            if ($logger->supports($level)) {
                $logger->log($this->buildMessage($level, $message));
            }
        }
    }

    private function buildMessage(LogLevel $level, string $message): LogMessage
    {
        return LogMessage::create(
            level: $level,
            environment: 'local',
            application: 'Events',
            context: 'context',
            message: $message,
        );
    }
}
