<?php

use App\Shared\Infrastructure\AppServiceProvider;

return [
    AppServiceProvider::class,
    \App\Admin\Customer\Infrastructure\AppServiceProvider::class,
    \App\Admin\User\Infrastructure\AppServiceProvider::class
];
