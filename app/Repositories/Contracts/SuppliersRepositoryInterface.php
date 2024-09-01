<?php

namespace App\Repositories\Contracts;

interface SuppliersRepositoryInterface
{
    public function fetchAllSuppliers();
    public function storeSupplier(array $formSupplier);
    public function updateSupplier($formSupplier, $upplierId);
    public function deleteSupplier($upplierId);
}