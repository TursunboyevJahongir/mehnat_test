<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(static function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::prefix('admin')->group(static function () {
        Route::get('me', [AdminController::class, 'me']);
        Route::post('me', [AdminController::class, 'update']);

        Route::get('roles', [RoleController::class, 'index'])->middleware('can:read role');
        Route::get('permissions', [RoleController::class, 'permissions'])->middleware('can:read role');
        Route::get('role/{name}', [RoleController::class, 'show'])->middleware('can:read role');
        Route::post('role', [RoleController::class, 'create'])->middleware('can:create role');
        Route::post('role/{name}', [RoleController::class, 'update'])->middleware('can:update role');
        Route::delete('role/{name}', [RoleController::class, 'delete'])->middleware('can:delete role');
    });
});
