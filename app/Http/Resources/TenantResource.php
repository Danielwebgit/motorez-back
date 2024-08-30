<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'domain' => 'http://'.$this->domain,
            'database' => $this->database,
            'tenancy_db_name' => $this->tenancy_db_name,
            'created_at' => (new DateTime($this->created_at))->format('d-m-Y'),
            'updated_at' => (new DateTime($this->updated_at))->format('d-m-Y'),

        ];
    }
}
