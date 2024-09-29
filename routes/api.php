<?php

use App\Admin\Customer\Infrastructure\Entrypoint\Http\PostCustomerController;
use App\Admin\Customer\Infrastructure\Entrypoint\Http\PutActivateCustomerController;
use App\Admin\Customer\Infrastructure\Entrypoint\Http\PutDeactivateCustomerController;
use App\Admin\User\Infrastructure\Entrypoint\Http\GetUserController;
use App\Admin\User\Infrastructure\Entrypoint\Http\PostUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::prefix('/customers')->group(function() {
       Route::post('/', PostCustomerController::class);
       Route::put('/{id}/activate', PutActivateCustomerController::class);
       Route::put('/{id}/deactivate', PutDeactivateCustomerController::class);
       Route::post('/{id}/users', PostUserController::class);
       // Route::get('users', GetCustomerUsersController::class);
    });

    Route::prefix('/users')->group(function() {
        Route::get('/{id}', GetUserController::class);
        // Route::put('/{id}/activate', PutActivateUserController::class);
        // Route::put('/{id}/deactivate', PutDeactivateUserController::class);
    });
});

