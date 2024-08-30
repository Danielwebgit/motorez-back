<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;

class TenantRepository implements TenantRepositoryInterface
{
    public function __construct(
        protected Tenant $model
    ) {}

    public function fetchAllTenants()
    {
        $tenants = $this->model->query()->get();
        return TenantResource::collection($tenants);
    }
}