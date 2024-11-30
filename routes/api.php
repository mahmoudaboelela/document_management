<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('documents')->group(function () {
    Route::post('/', [DocumentController::class, 'store'])->middleware('role:Admin|User');
    Route::get('/{id}', [DocumentController::class, 'show']);
    Route::post('/search', [DocumentController::class, 'search'])->middleware('role:Admin|User');
    Route::delete('/{id}', [DocumentController::class, 'destroy'])->middleware('role:Admin|User');
    Route::get('/versions/{id}', [DocumentController::class, 'versions'])->middleware('role:Admin|User');
})->middleware('auth:sanctum');
foreach (glob(base_path('modules/*/Routes/api.php')) as $routeFile) {
    require $routeFile;
}

