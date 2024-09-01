<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuppliersRequest;
use App\Services\SuppliersService;

class SuppliersController extends Controller
{
    public function __construct(private SuppliersService $suppliersService)
    {}

    public function fetchAllSuppliers()
    {
        return $this->suppliersService->fetchAllSuppliers();
    }

    public function storeSupplier(SuppliersRequest $suppliersRequest)
    {
        return $this->suppliersService->storeSupplier($suppliersRequest->input());
    }

    public function updateSupplier($formSuppliers, $supplierId)
    {
        $supplierId = request()->route('supplierId');
        return $this->suppliersService->updateSupplier($formSuppliers, $supplierId);
    }

    public function deleteSupplier($supplierId)
    {
        $supplierId = request()->route('supplierId');
        return $this->suppliersService->deleteSupplier($supplierId);
    }

}
