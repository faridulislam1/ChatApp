
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\LayoutController;
use App\Http\Middleware\SuperTokenMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NotificationController;

    Route::get('/test', function () {
        return response()->json(['message' => 'API routes are working!']);
    });

    
Route::get('/activate-users', [UserController::class, 'activateUsers']);


    Route::post('/register', [AuthController::class, 'register']);
    // Route::post('/login', [AuthController::class, 'login']);

    // Route::middleware('throttle:5,1')->group(function () {
    //     Route::post('/login', [AuthController::class, 'login']);
    // });

    
    Route::middleware('throttle:5,1')->post('/login', [AuthController::class, 'login']);

    Route::middleware([SuperTokenMiddleware::class])->group(function () {
        Route::get('/users', [AuthController::class, 'showuser']);
        Route::put('/users/{id}', [AuthController::class, 'updateuser']);
        Route::delete('/users/{id}', [AuthController::class, 'deleteuser']);    
        Route::get('/orders', [AuthController::class, 'get_orders']);

    });

    Route::middleware(['auth:sanctum', 'role:admin'])->post('/logout', [AuthController::class, 'logout']);
    Route::post('/layouts', [LayoutController::class, 'store']);
    Route::get('/layouts', [LayoutController::class, 'index']);
    Route::get('/layouts/{id}', [LayoutController::class, 'show']);

    Route::post('/image', [ImageController::class, 'storeimage']);

    Route::get('/cloud', function () {
        return config('cloudinary.cloud_url');
    });



   Route::post('/notify', [NotificationController::class, 'notify']);

    