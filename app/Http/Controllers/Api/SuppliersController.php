<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuppliersRequest;
use App\Services\SuppliersService;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function __construct(private SuppliersService $suppliersService)
    {}

    public function storeSupplier(SuppliersRequest $suppliersRequest)
    {
        return $this->suppliersService->storeSupplier($suppliersRequest->input());
    }

    public function fetchAllSuppliers()
    {
        return $this->suppliersService->fetchAllSuppliers();
    }
}
