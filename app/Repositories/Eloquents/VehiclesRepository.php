<?php

namespace App\Repositories\Eloquents;

use App\Models\Vehicle;
use App\Repositories\Contracts\VehiclesRepositoryInterface;
use Illuminate\Support\Facades\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class VehiclesRepository implements VehiclesRepositoryInterface
{
    public function __construct(
        protected Vehicle $model
    ) {}

    public function fetchAllVehicles()
    {
        $page = Request::query('page') ?? request('page', 1);
        $perPage = 5;
        $searchBrandOrModel = Request::query('brandOrModel') ?? "";
        $yearSearch = Request::query('year') ?? "";
        $versionSearch = Request::query('version') ?? "";
        $fuelSearch = Request::query('fuel') ?? "";
        $doorsSearch = Request::query('doors') ?? "";
        $suppliersIdSearch = Request::query('suppliers_id') ?? "";
        $dateRegistre = Request::query('created_at') ?? "";

        $query = $this->model->query();

        if ($searchBrandOrModel) {

            $query->where(
                function ($query) use ($searchBrandOrModel) {
                    $query->where('brand', 'LIKE', "%{$searchBrandOrModel}%")
                        ->orWhere('model', 'LIKE', "%{$searchBrandOrModel}%");
                }
            );
        }

        if ($yearSearch) {
            $query->where(function ($q) use ($yearSearch) {
                $q->where('year', 'LIKE', '%' . $yearSearch . '%');
            });
        }

        if ($versionSearch) {
            $query->where(function ($q) use ($versionSearch) {
                $q->where('version', 'LIKE', '%' . $versionSearch . '%');
            });
        }

        if ($fuelSearch) {
            $query->where(function ($q) use ($fuelSearch) {
                $q->where('fuel', 'LIKE', '%' . $fuelSearch . '%');
            });
        }

        if ($doorsSearch) {
            $query->where(function ($q) use ($doorsSearch) {
                $q->where('doors', 'LIKE', '%' . $doorsSearch . '%');
            });
        }

        if ($suppliersIdSearch) {
            $query->where(function ($q) use ($suppliersIdSearch) {
                $q->where('suppliers_id', 'LIKE', '%' . $suppliersIdSearch . '%');
            });
        }

        if ($dateRegistre) {
            $query->where(function ($q) use ($dateRegistre) {
                $q->orWhere('created_at', 'LIKE', '%' . $dateRegistre . '%');
            });
        }

        $vehicles = $query->orderBy('id', 'asc')->get();

        $paginatedData = new LengthAwarePaginator(
            $vehicles->forPage($page, $perPage),
            $vehicles->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return $paginatedData;
    }
}
