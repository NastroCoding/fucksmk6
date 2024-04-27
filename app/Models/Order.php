<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function buses() {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function drivers() {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
