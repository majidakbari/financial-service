<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transaction\StoreTransactionController;

Route::prefix('/transaction')
    ->as('transaction.')
    ->group(function () {
        Route::post('/', StoreTransactionController::class)->name('store');
    });
