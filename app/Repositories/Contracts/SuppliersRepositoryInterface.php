<?php

namespace App\Repositories\Contracts;

interface SuppliersRepositoryInterface
{
    public function storeSupplier(array $formSupplier);
    public function fetchAllSuppliers();
}