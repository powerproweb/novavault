<?php

use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ----- API v1 (Sanctum token auth) -----
Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    // Vendor endpoints
    Route::get('/vendor/profile', [ApiController::class, 'vendorProfile']);
    Route::get('/vendor/products', [ApiController::class, 'products']);
    Route::post('/vendor/products', [ApiController::class, 'storeProduct']);
    Route::put('/vendor/products/{product}', [ApiController::class, 'updateProduct']);
    Route::delete('/vendor/products/{product}', [ApiController::class, 'deleteProduct']);
    Route::get('/vendor/orders', [ApiController::class, 'orders']);
    Route::get('/vendor/orders/{order}', [ApiController::class, 'orderDetail']);

    // Patron endpoints
    Route::get('/patron/balance', [ApiController::class, 'patronBalance']);
    Route::get('/patron/activity', [ApiController::class, 'tokenActivity']);
});
