<?php

namespace App\Shared\Infrastructure\Http\Middleware;

use App\Shared\Infrastructure\Services\RequesterInfo\HttpRequestMetadata;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenValidator
{
    public function __construct(
        private readonly HttpRequestMetadata $httpRequestMetadata
    )
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-Token');
        $this->httpRequestMetadata->build($token);

        return $next($request);
    }
}
