<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'barang_id',
        'gudang_id',
        'kuantitas',
        'barang_nama',
        'harga',
        'subtotal',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang')->withTrashed();
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }
}
