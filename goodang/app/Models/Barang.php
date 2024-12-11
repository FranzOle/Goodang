<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['id_kategori', 'id_supplier', 'kode_sku', 'nama', 'deskripsi', 'gambar'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function jumlahstok()
    {
        return $this->hasMany(JumlahStok::class, 'id_barang');
    }

    public function transaksidetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_barang');
    } 
}