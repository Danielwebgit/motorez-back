<?php

use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\FileImportsDataVehiclesController;
use App\Http\Controllers\Api\SuppliersController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\VehiclesController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([InitializeTenancyByDomain::class,PreventAccessFromCentralDomains::class,
])->domain('{tenancy}.localhost')->group(function () {
    
    Route::prefix('v1')->group(function () {
        Route::prefix('/auth/user')->group(function () {
            Route::post('/login', [AuthUserController::class, 'login']);
            Route::post('/refresh-token', [AuthUserController::class, 'refreshToken']);
            Route::group(['middleware' => ['apiJwt']], function () {
                Route::post('/logout', [AuthUserController::class, 'logout']);
            });
            
        });

        Route::group(['middleware' => ['apiJwt']], function () {

            Route::prefix('/vehicles')->group(function () {
                Route::get('/', [VehiclesController::class, 'fetchAllVehicles']);
                Route::put('/update/{vehicleId}', [VehiclesController::class, 'updateVehicle']);
                Route::delete('/delete/{vehicleId}', [VehiclesController::class, 'deleteVehicle']);

                Route::post('/file-imports-data-vehicles', [FileImportsDataVehiclesController::class, 'fileImportsDataVehicles']);
            });

            Route::prefix('/suppliers')->group(function () {
                Route::get('/', [SuppliersController::class, 'fetchAllSuppliers']);
                Route::post('/store', [SuppliersController::class, 'storeSupplier']);
                Route::put('/update/{supplierId}', [SuppliersController::class, 'updateSupplier']);
                Route::delete('/delete/{supplierId}', [SuppliersController::class, 'deleteSupplier']);
            });

        });

    });
});

// Rotas globais fora do contexto do tenant
Route::prefix('v1')->group(function () {

    Route::prefix('/auth/user')->group(function () {
        Route::post('/login', [AuthUserController::class, 'login']);
        Route::post('/refresh-token', [AuthUserController::class, 'refreshToken']);
        Route::group(['middleware' => ['apiJwt']], function () {
            Route::post('/logout', [AuthUserController::class, 'logout']);
        });
    });

    Route::group(['middleware' => ['apiJwt']], function () {
        Route::prefix('/tenants')->group(function () {
            Route::get('/', [TenantController::class, 'fetchAllTenants']);
        });
    });
});
