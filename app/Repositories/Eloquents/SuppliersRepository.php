<?php

namespace App\Repositories\Eloquents;

use App\Models\Supplier;
use App\Repositories\Contracts\SuppliersRepositoryInterface;
use Exception;

class SuppliersRepository implements SuppliersRepositoryInterface
{
    public function __construct(
        protected Supplier $model
    ) {}

    public function fetchAllSuppliers()
    {
        return $this->model->query()->with('vehicles')->get();
    }

    public function storeSupplier($formSupplier)
    {
        return $this->model->query()->create(['name' => $formSupplier['name']]);
    }

    public function updateSupplier($formSupplier, $upplierId)
    {
        $supplier = $this->model->query()->find($upplierId);
        $supplier->name = $formSupplier['name'];
        $supplier->save();
    }

    public function deleteSupplier($supplierId)
    {
        return $this->model->query()->find($supplierId)->delete();

        try {

            if ($this->model->query()->find($supplierId)->delete())
            {
                return response()->json(['msg' => 'Fornecedor deletado!']);
            }

            return response()->json(['msg' => 'Fornecedor não encontrado']);

        } catch (Exception $e) {
            return response()->json(['error' => 'Não pode deletar, verificar consultar regras de negócios']);
        }
    }
    
}