<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Statusgizi;

class Pesertadidik extends Model
{
    use HasFactory;

    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'idortu',
        'namapd',
        'tanggallahir',
        'jeniskelamin',
        'kelas',
        'fase',
        'tinggibadan',
        'beratbadan',
        'foto',
        'file_penilaian'
    ];

    public function orangtua()
    {
        return $this->belongsTo(Orangtua::class, 'idortu');
    }


    public function statusgizi()
    {
        return $this->hasOne(StatusGizi::class, 'nis', 'nis');
    }

    public function statusgiziTerbaru()
    {
        return $this->hasOne(Statusgizi::class, 'nis', 'nis')->latestOfMany('idstatus');
    }
}
