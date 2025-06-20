<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statusgizi extends Model
{
    use HasFactory;

    protected $primaryKey = 'idstatus';
    protected $fillable = [
        'nis', 
        'z_score', 
        'status', 
        'tanggalpembuatan',
    ];

    public function pesertadidik()
    {
        return $this->belongsTo(Pesertadidik::class, 'nis', 'nis');
    }
}
