<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['namaortu', 'notelportu', 'emailortu','nickname'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pesertadidiks()
    {
        return $this->hasMany(Pesertadidik::class, 'idortu');
    }

}
