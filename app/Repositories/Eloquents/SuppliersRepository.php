<?php

namespace App\Repositories\Eloquents;

use App\Models\Supplier;
use App\Repositories\Contracts\SuppliersRepositoryInterface;

class SuppliersRepository implements SuppliersRepositoryInterface
{
    public function __construct(
        protected Supplier $model
    ) {}

    public function fetchAllSuppliers()
    {
        return $this->model->query()->with('vehicles')->get();
    }
}