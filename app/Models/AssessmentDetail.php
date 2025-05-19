<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'aspect',
        'indicator',
        'score',
        'comment'
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}