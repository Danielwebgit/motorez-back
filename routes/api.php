<?php

use App\Http\Controllers\Api\AuthUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([InitializeTenancyByDomain::class,PreventAccessFromCentralDomains::class,
])->domain('{tenancy}.localhost')->group(function () {
    
    Route::prefix('v1')->group(function () {
        Route::prefix('/auth/user')->group(function () {
            Route::post('/login', [AuthUserController::class, 'login']);
            
            Route::group(['middleware' => ['apiJwt']], function () {
                Route::post('/logout', [AuthUserController::class, 'logout']);
            });
            
        });
    });
});
