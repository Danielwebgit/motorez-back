<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SuppliersService;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function __construct(private SuppliersService $suppliersService)
    {}

    public function fetchAllSuppliers()
    {
        return $this->suppliersService->fetchAllSuppliers();
    }
}
