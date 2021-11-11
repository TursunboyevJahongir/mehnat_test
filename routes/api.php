<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\RoleController;
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
        Route::put('me', [AdminController::class, 'update']);

        Route::get('roles', [RoleController::class, 'index'])->middleware('can:read role');
        Route::get('permissions', [RoleController::class, 'permissions'])->middleware('can:read role');
        Route::get('role/{name}', [RoleController::class, 'show'])->middleware('can:read role');
        Route::post('role', [RoleController::class, 'create'])->middleware('can:create role');
        Route::put('role/{name}', [RoleController::class, 'update'])->middleware('can:update role');
        Route::delete('role/{name}', [RoleController::class, 'delete'])->middleware('can:delete role');

        Route::get('position', [PositionController::class, 'index'])->middleware('can:read position');
        Route::post('position', [PositionController::class, 'create'])->middleware('can:create position');
        Route::put('position/{id}', [PositionController::class, 'update'])->middleware('can:update position');
        Route::delete('position/{id}', [PositionController::class, 'delete'])->middleware('can:delete position');

        Route::get('company/{company}/employee', [EmployeeController::class, 'companyEmployees'])->middleware('can:read employee');
        Route::get('all/employee', [EmployeeController::class, 'index'])->middleware('can:read employee');
        Route::get('employee/{id}', [EmployeeController::class, 'show'])->middleware('can:read employee');
        Route::post('employee', [EmployeeController::class, 'create'])->middleware('can:create employee');
        Route::put('employee', [EmployeeController::class, 'update'])->middleware('can:update employee');
        Route::delete('employee/{id}', [EmployeeController::class, 'delete'])->middleware('can:delete employee');
    });
});
