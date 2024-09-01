<?php

namespace App\Services;

use App\Repositories\Eloquents\SuppliersRepository;

class SuppliersService
{
    public function __construct(
        private SuppliersRepository $suppliersRepository
    ) {}

    public function fetchAllSuppliers()
    {
        return $this->suppliersRepository->fetchAllSuppliers();
    }

    public function storeSupplier($formSupplier)
    {
        return $this->suppliersRepository->storeSupplier($formSupplier);
    }
    
    public function updateSupplier($formSupplier, $supplierId)
    {
        return $this->suppliersRepository->updateSupplier($formSupplier, $supplierId);
    }

    public function deleteSupplier($supplierId)
    {
        return $this->suppliersRepository->deleteSupplier($supplierId);
    }

}