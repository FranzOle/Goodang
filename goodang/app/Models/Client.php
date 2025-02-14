<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'no_telepon', 'email'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

