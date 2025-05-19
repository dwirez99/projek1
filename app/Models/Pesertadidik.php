<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assessment;
use App\Models\StatusGizi;

class Pesertadidik extends Model
{
    use HasFactory;

    protected $primaryKey = 'nisn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nisn', 'idortu', 'namapd', 'tanggallahir', 'jeniskelamin',
        'kelas', 'tahunajar', 'semester', 'fase', 'tinggibadan', 'beratbadan', 'foto'
    ];

    public function orangtua()
    {
        return $this->belongsTo(Orangtua::class, 'idortu');
    }

    public function assessments()
    {
    return $this->hasMany(Assessment::class, 'nisn', 'nisn');
    }

    public function statusgizi()
    {
        return $this->hasOne(Statusgizi::class, 'nisn', 'nisn');
    }

}

