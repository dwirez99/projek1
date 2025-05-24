<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StatusGizi;

class Pesertadidik extends Model
{
    use HasFactory;

    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idortu', 'namapd', 'tanggallahir', 'jeniskelamin',
        'kelas', 'semester', 'fase', 'tinggibadan', 'beratbadan', 'foto','file_penilaian', 'tahunajar'
    ];

    public function orangtua()
    {
        return $this->belongsTo(Orangtua::class, 'idortu');
    }


    public function statusgizi()
    {
        return $this->hasOne(Statusgizi::class, 'nis', 'nis');
    }
}
