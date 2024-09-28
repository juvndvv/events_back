<?php

namespace App\Shared\Infrastructure\Services\RequesterInfo;

interface HttpRequestMetadata
{
    public function build(string $token): self;
    public function getUserId(): string;
    public function getCustomerId(): string;
}
