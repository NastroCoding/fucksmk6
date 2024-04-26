<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function buses() {
        $this->belongsTo(Bus::class);
    }

    public function drivers() {
        $this->belongsTo(Driver::class);
    }
}
