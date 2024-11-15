<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\ExceptionHandler;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $e): void
    {
        Log::critical($e->getMessage(), ['exception' => $e]);
    }
}
