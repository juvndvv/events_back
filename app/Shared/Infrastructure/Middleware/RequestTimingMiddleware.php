<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Middleware;


use App\Shared\Infrastructure\Service\Session\Session;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RequestTimingMiddleware
{
    public function __construct(
        private readonly Session $session
    )
    {
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
        // Registrar la hora de inicio y el endpoint
        $this->session->setRequestStartTime();
        $this->session->setEndpoint($request->path());
        $this->session->setIpAddress($request->ip());

        // Procesar la solicitud
        $response = $next($request);

        // Registrar la hora de finalización
        $this->session->setRequestEndTime();

        // Obtener la duración de la solicitud
        $duration = $this->session->getRequestDuration();

        // TODO implementar que hacer con la session

        return $response;
    }
}
