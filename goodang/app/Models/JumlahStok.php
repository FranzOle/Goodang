<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JumlahStok extends Model
{
    use HasFactory;

    protected $fillable = ['id_barang', 'id_gudang', 'kuantitas'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'id_gudang');
    }
}
