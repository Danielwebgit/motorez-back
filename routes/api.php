<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([InitializeTenancyByDomain::class,PreventAccessFromCentralDomains::class,
])->domain('{tenancy}.localhost')->group(function () {
    
    Route::get('/', function ($tenancy) {

        
    });
});
