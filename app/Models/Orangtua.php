<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    use HasFactory;

    protected $fillable = ['namaortu', 'notelportu', 'emailortu'];

    public function pesertadidiks()
    {
        return $this->hasMany(Pesertadidik::class, 'idortu');
    }
}


