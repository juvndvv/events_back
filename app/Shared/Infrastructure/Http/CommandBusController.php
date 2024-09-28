<?php

namespace App\Shared\Infrastructure\Http;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infrastructure\Services\RequesterInfo\HttpRequestMetadata;

abstract class CommandBusController extends Controller
{
    public function __construct(
        protected HttpRequestMetadata $httpRequestMetadata,
        protected CommandBus $bus,
    )
    {
        parent::__construct($this->httpRequestMetadata);
    }
}
