<?php

namespace Tests\Shared\Infrastructure\Service\Logger\Implementation\Slack;

use App\Shared\Infrastructure\Middleware\QueryTimmingMiddleware;
use App\Shared\Infrastructure\Middleware\RequestTimingMiddleware;
use App\Shared\Infrastructure\Service\Logger\Implementation\Slack\SlackLogger;
use App\Shared\Infrastructure\Service\Logger\LogLevel;
use App\Shared\Infrastructure\Service\Logger\LogMessage;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('production')]
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

    public function testSessionRequest(): void
    {
        Route::get('/api/test-session-route', function () {
            return response()->json(['message' => 'This is a test route.']);
        })->middleware([
            RequestTimingMiddleware::class,
            QueryTimmingMiddleware::class
        ]);

        $this->get('/api/test-session-route');
    }
}
