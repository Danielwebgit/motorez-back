<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'suppliers_id');
    }
}
