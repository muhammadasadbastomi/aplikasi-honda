<?php

namespace App\Models;

use App\Models\Sparepart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Retur extends Model
{
    protected $guarded = [''];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
