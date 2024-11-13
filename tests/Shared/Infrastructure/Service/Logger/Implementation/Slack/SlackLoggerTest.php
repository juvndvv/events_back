<?php

namespace Tests\Shared\Infrastructure\Service\Logger\Implementation\Slack;

use App\Shared\Infrastructure\Service\Logger\Implementation\Slack\SlackLogger;
use App\Shared\Infrastructure\Service\Logger\LogLevel;
use App\Shared\Infrastructure\Service\Logger\LogMessage;
use Tests\TestCase;

/**
 * @group application-infra
 * @group logger
 */
class SlackLoggerTest extends TestCase
{
    private SlackLogger $logger;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = $this->app->make(SlackLogger::class);
    }

    public function testItShouldSendToSlack(): void
    {
        $message = LogMessage::create(
            LogLevel::CRITICAL,
            'testing',
            'Events',
            'request-0',
            'This is a test message'
        );

        $this->logger->log($message);

        $this->expectNotToPerformAssertions();
    }
}
