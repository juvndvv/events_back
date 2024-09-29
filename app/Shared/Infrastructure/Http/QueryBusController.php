<?php

namespace App\Shared\Infrastructure\Http;

use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infrastructure\Services\RequesterInfo\HttpRequestMetadata;

abstract class QueryBusController extends Controller
{
    public function __construct(
        protected HttpRequestMetadata $httpRequestMetadata,
        protected QueryBus $queryBus
    )
    {
        parent::__construct($httpRequestMetadata);
    }
}
