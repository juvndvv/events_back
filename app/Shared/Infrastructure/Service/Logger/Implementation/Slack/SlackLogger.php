<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Logger\Implementation\Slack;


use App\Shared\Infrastructure\Service\Logger\Implementation\LoggerStrategy;
use App\Shared\Infrastructure\Service\Logger\LogLevel;
use App\Shared\Infrastructure\Service\Logger\LogMessage;
use Exception;
use GuzzleHttp\Client;

readonly class SlackLogger implements LoggerStrategy
{
    private Client $httpClient;

    private string $url;

    public function __construct(
        Client $client,
    )
    {
        $this->httpClient = $client;
        $this->url = config('services.slack.url');
    }

    public function log(LogMessage $message): void
    {
        $request = SlackLoggerRequest::create($message);
        $payload = $request->getPayload();

        try {
            $this->httpClient->post($this->url, $payload);

        } catch (Exception $e) {
            error_log('Error al enviar el mensaje a Slack: ' . $e->getMessage());
        }
    }

    public function supports(LogLevel $level): array
    {
        return [
            LogLevel::CRITICAL,
            LogLevel::ERROR,
        ];
    }
}
