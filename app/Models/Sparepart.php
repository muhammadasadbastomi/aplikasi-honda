<?php

namespace App\Models;

use App\Models\Stok;
use App\Models\Promo;
use App\Models\PembelianDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sparepart extends Model
{
    protected $guarded = ['id'];

    public function pembelian_detail()
    {
        return $this->hasMany(PembelianDetail::class);
    }

    public function stok()
    {
        return $this->hasOne(Stok::class);
    }

    public function promo()
    {
        return $this->hasOne(Promo::class);
    }
}
