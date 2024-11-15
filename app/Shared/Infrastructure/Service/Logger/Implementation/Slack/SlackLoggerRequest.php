<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Logger\Implementation\Slack;

use App\Shared\Infrastructure\Service\Logger\LogMessage;

readonly class SlackLoggerRequest
{
    protected function __construct(
        private LogMessage $message,
    ) {
    }

    public function getPayload(): array
    {
        return [
            'username' => $this->message->getAppName(),
            'icon_emoji' => ':ghost:',
            'text' => $this->message->__toString(),
        ];
    }

    public static function create(LogMessage $message): self
    {
        return new self($message);
    }
}
