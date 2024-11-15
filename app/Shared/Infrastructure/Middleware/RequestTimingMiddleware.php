<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Middleware;

use App\Shared\Infrastructure\Service\Session\SessionTiming;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

readonly class RequestTimingMiddleware
{
    public function __construct(
        private SessionTiming $session,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        DB::enableQueryLog();

        $this->session->setRequestStartTime();
        $this->session->setEndpoint($request->path());
        $this->session->setIpAddress($request->ip());

        $response = $next($request);

        $this->session->setRequestEndTime();
        $this->setQueryInfo();

        // TODO implementar que hacer con la session

        return $response;
    }

    private function setQueryInfo(): void
    {
        $queries = DB::getQueryLog();

        $duration = 0;
        foreach ($queries as $query) {
            $duration += $query->time;
        }

        $this->session->setQueryDuration($duration);
    }
}
