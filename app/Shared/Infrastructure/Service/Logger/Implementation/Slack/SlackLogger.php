<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Logger\Implementation\Slack;

use App\Shared\Infrastructure\Service\HttpClient\HttpClient;
use App\Shared\Infrastructure\Service\HttpClient\Method;
use App\Shared\Infrastructure\Service\Logger\Implementation\LoggerStrategy;
use App\Shared\Infrastructure\Service\Logger\LogLevel;
use App\Shared\Infrastructure\Service\Logger\LogMessage;

readonly class SlackLogger implements LoggerStrategy
{
    private HttpClient $httpClient;

    private string $url;

    public function __construct(
        HttpClient $client,
    ) {
        $this->httpClient = $client;
        $this->url = config('services.slack.url');
    }

    public function log(LogMessage $message): void
    {
        $request = SlackLoggerRequest::create($message);
        $payload = $request->getPayload();

        $this->httpClient
            ->setUri($this->url)
            ->setMethod(Method::POST)
            ->addBodyParams($payload)
            ->send();
    }

    public function supports(LogLevel $level): array
    {
        return [
            LogLevel::CRITICAL,
            LogLevel::ERROR,
            LogLevel::WARNING,
            LogLevel::INFO,
            LogLevel::DEBUG,
        ];
    }
}
