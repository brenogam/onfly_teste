<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TakeoutOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/auth', [AuthController::class, 'auth']);

Route::get('/unauthenticated', function () {
    return response()->json([
        'message' => 'Não autenticado',
    ], 401);
})->name('unauthenticated');

Route::middleware('auth:api')->group(function () {
    Route::post('/createOrder', [TakeoutOrderController::class, 'createOrder']);
    Route::put('/updateOrder/{id}/status', [TakeoutOrderController::class, 'updateOrder']);
    Route::get('/consultOrder/{id}', [TakeoutOrderController::class, 'consultOrder']);
    Route::get('/indexOrders', [TakeoutOrderController::class, 'indexOrders']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
