<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\HttpClient;

use Psr\Http\Message\ResponseInterface;

interface HttpClient
{
    public function setMethod(Method $method): self;
    public function setUri(string $uri): self;
    public function addHeader(string $name, string $value): self;
    public function addQueryParam(string $name, string $value): self;
    public function addBodyParam(string $name, $value): self;
    public function addBodyParams(array $params): self;
    public function send(): ResponseInterface;

}
