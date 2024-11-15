<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Service\ExceptionHandler;

use App\Shared\Infrastructure\Service\ExceptionHandler\AppExceptionHandler;
use App\Shared\Infrastructure\Service\Logger\Logger;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;

/**
 * @group infra
 */
class AppExceptionHandlerTest extends TestCase
{
    private $exceptionHandler;

    protected function setUp(): void
    {
        $this->exceptionHandler = app()->make(AppExceptionHandler::class);
    }

    public function testReportLogsError(): void
    {
        $exception = new \Exception('Test exception message');

        $this->exceptionHandler->report($exception);
    }
}
