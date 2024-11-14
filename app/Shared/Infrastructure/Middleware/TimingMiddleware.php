<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Middleware;

use App\Shared\Infrastructure\Service\Session\Session;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

readonly class TimingMiddleware
{
    public function __construct(
        private Session $session
    ) {}

    /**
     * Handle an incoming request and measure performance metrics.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->startRequestLogging($request);
        $this->startQueryLogging();

        $response = $next($request);

        $this->endRequestLogging();
        $this->logQueryMetrics();

        // TODO: Implementar la lógica de almacenamiento o procesamiento de la sesión

        return $response;
    }

    private function startRequestLogging(Request $request): void
    {
        $this->session->setRequestStartTime();
        $this->session->setEndpoint($request->path());
        $this->session->setIpAddress($request->ip());
    }

    private function startQueryLogging(): void
    {
        DB::enableQueryLog();
    }

    private function endRequestLogging(): void
    {
        $this->session->setRequestEndTime();
    }

    private function logQueryMetrics(): void
    {
        $queries = DB::getQueryLog();

        $totalQueries = count($queries);
        $totalQueryTime = array_reduce($queries, fn($carry, $query) => $carry + $query['time'], 0);

        $this->session->setQueriesExecuted($totalQueries);
        $this->session->setTotalQueryTime($totalQueryTime);
    }
}
