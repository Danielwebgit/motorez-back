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
}