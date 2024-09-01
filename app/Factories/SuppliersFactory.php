<?php

namespace App\Factories;

use App\Repositories\Contracts\SuppliersRepositoryInterface;
use App\Services\SuppliersService;

class SuppliersFactory
{
    public static function create(): SuppliersService
    {
        $supplier = app(SuppliersRepositoryInterface::class);

        return new SuppliersService($supplier);
    }
}
