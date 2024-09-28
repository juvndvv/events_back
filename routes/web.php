<?php

use App\Admin\Customer\Infrastructure\Entrypoint\Http\PostCustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', PostCustomerController::class);
