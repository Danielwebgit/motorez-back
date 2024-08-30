<?php

namespace App\Services;

use App\Repositories\Eloquents\TenantRepository;

class TenantService
{
    public function __construct(
        private TenantRepository $tenantRepository
    ) {}

    public function fetchAllTenants()
    {
        return $this->tenantRepository->fetchAllTenants();
    }
}