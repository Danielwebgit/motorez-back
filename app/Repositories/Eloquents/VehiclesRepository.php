<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Repositories\Contracts\VehiclesRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;

class VehiclesRepository implements VehiclesRepositoryInterface
{
    public function __construct(
        protected Vehicle $model
    ) {}

    public function fetchAllVehicles()
    {
        $page = Request::query('page') ?? request('page', 1);
        $perPage = 12;
        $searchBrandOrModel = Request::query('brandOrModel') ?? "";
        $yearSearch = Request::query('year') ?? "";
        $versionSearch = Request::query('version') ?? "";
        $fuelSearch = Request::query('fuel') ?? "";
        $doorsSearch = Request::query('doors') ?? "";
        $suppliersIdSearch = Request::query('suppliers_id') ?? "";
        $dateRegistre = Request::query('created_at') ?? "";

        $query = $this->model->query()->with('supplier');

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
        $vehiclesResource = VehicleResource::collection($vehicles);
        $paginatedData = new LengthAwarePaginator(
            $vehiclesResource->forPage($page, $perPage),
            $vehiclesResource->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]);

        return $paginatedData;
    }

    public function updateVehicle($formVehicle, $vehicleId)
    {
        try {

            if ($supplier = $this->model->query()->find($vehicleId)) {
                $supplier->brand = $formVehicle['brand'];
                $supplier->model = $formVehicle['model'];
                $supplier->save();

                return response()->json(['msg' => 'Veículo atualizado!']);
            } 
            
            return response()->json(['msg' => 'Veículo atualizado!']);
            
        } catch (Exception $e) {
            Log::critical($e->getMessage());
        }
    }

    public function deleteVehicle($vehicleId)
    {
        try {

            if ($this->model->query()->find($vehicleId)->delete())
            {
                return response()->json(['msg' => 'Veículo deletado!']);
            }

            return response()->json(['msg' => 'Veículo não encontrado']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function importDataVehicles(array $data, $extension)
    {
        $data = $data;
    }

    public function verifyRegisteredCode($codeVehicle)
    {
        return $this->model->query()->where('code', $codeVehicle)->exists();
    }
}
