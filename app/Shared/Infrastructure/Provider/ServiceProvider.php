<?php

namespace App\Shared\Infrastructure\Provider;

interface ServiceProvider
{
    public function register(): void;
    public function boot(): void;
}
