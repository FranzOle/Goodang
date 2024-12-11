<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_gudang', 'deskripsi_tujuan', 'kode_referensi', 'tanggal', 'stock_type',
    ];

    
    /**
     * Relasi ke tabel Gudang.
     */
    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'id_gudang');
    }

    /**
     * Relasi ke tabel TransaksiDetail.
     */
    public function transaksidetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_transaksi');
    }
}
