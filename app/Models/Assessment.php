<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model {
    protected $fillable = [
        'nisn',
        'teacher_id',
        'assessment_date',
        'notes'
    ];

    protected $casts = [
        'assessment_date' => 'datetime',
    ];

    public function pesertadidik() {
        return $this->belongsTo(Pesertadidik::class, 'nisn');
    }

    public function details() {
        return $this->hasMany(AssessmentDetail::class);
    }
}
