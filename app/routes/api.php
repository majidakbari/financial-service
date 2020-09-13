<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transaction\StoreTransactionController;

Route::as('api.')->group(function() {
    Route::prefix('/transaction')
        ->as('transaction.')
        ->group(function () {
            Route::post('/', StoreTransactionController::class)->name('store');
        });
});
