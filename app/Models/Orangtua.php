<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['namaortu', 'notelportu', 'alamat', 'emailortu','nickname'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // sesuaikan jika nama kolomnya berbeda
    }


    public function pesertadidiks()
    {
        return $this->hasMany(Pesertadidik::class, 'idortu');
    }

    

}
