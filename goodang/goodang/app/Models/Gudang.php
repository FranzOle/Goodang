<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'alamat'];

    public function jumlahstok()
    {
        return $this->hasMany(JumlahStok::class, 'id_gudang');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_gudang');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id_gudang');
    }

}
