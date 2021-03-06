<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DirectorEmployeeController;
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

Route::middleware('jwt.verify')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh/{type}', [AuthController::class, 'refresh']);

    Route::middleware('auth:admin-api')->prefix('admin')->group(static function () {
        Route::get('me', [AdminController::class, 'me']);
        Route::put('me', [AdminController::class, 'updateProfile']);

        Route::get('admins', [AdminController::class, 'index'])->middleware('can:read admin');
        Route::get('admins/{id}', [AdminController::class, 'show'])->middleware('can:read admin');
        Route::post('admins', [AdminController::class, 'create'])->middleware('can:create admin');
        Route::put('admins', [AdminController::class, 'update'])->middleware('can:update admin');
        Route::delete('admins/{id}', [AdminController::class, 'delete'])->middleware('can:delete admin');

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

        Route::get('company', [CompanyController::class, 'index'])->middleware('can:read company');
        Route::get('company/{id}', [CompanyController::class, 'show'])->middleware('can:read company');
        Route::post('company', [CompanyController::class, 'create'])->middleware('can:create company');
        Route::put('company', [CompanyController::class, 'update'])->middleware('can:create company');
        Route::delete('company/{id}', [CompanyController::class, 'delete'])->middleware('can:delete company');

        Route::get('company/{company}/employee', [EmployeeController::class, 'companyEmployees'])->middleware('can:read employee');
        Route::get('all/employee', [EmployeeController::class, 'index'])->middleware('can:read employee');
        Route::get('employee/{id}', [EmployeeController::class, 'show'])->middleware('can:read employee');
        Route::post('employee', [EmployeeController::class, 'create'])->middleware('can:create employee');
        Route::put('employee', [EmployeeController::class, 'update'])->middleware('can:update employee');
        Route::delete('employee/{id}', [EmployeeController::class, 'delete'])->middleware('can:delete employee');
    });

    Route::middleware('auth:employee-api')->prefix('employee')->group(static function () {
        Route::get('me', [DirectorEmployeeController::class, 'me']);
        Route::put('me', [DirectorEmployeeController::class, 'updateProfile']);

        Route::get('company', [CompanyController::class, 'myCompany']);

        Route::middleware('only.director')->prefix('company')->group(static function () {
            Route::put('/', [CompanyController::class, 'updateMyCompany']);

            Route::get('employee', [DirectorEmployeeController::class, 'index']);
            Route::get('employee/{id}', [DirectorEmployeeController::class, 'show']);
            Route::post('employee', [DirectorEmployeeController::class, 'create']);
            Route::put('employee', [DirectorEmployeeController::class, 'update']);
            Route::delete('employee/{id}', [DirectorEmployeeController::class, 'delete']);
        });
    });
});
