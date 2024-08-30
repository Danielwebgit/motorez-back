<?php

namespace App\Repositories\Eloquents;

use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;

class TenantRepository implements TenantRepositoryInterface
{
    public function __construct(
        protected Tenant $model
    ) {}

    public function fetchAllTenants()
    {
        return $this->model->query()->get();
    }
}