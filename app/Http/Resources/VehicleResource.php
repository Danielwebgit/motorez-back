<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [

            'id' => $this->id,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'version' => $this->version,
            'fuel' => $this->fuel,
            'doors' => $this->doors,
            'price' => $this->price,
            'suppliers_name' => $this->supplier->name,

        ];
    }
}
