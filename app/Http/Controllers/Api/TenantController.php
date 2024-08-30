<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\TenantService;

class TenantController extends Controller
{

    public function __construct(private TenantService $tenantService) 
    {}
   
    public function fetchAllTenants()
    {
        return $this->tenantService->fetchAllTenants();
    }
}
