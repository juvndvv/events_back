<?php

use App\Admin\Customer\Infrastructure\Entrypoint\Http\PostCustomerController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('/customers', PostCustomerController::class);
});

