<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KuccpsApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'intake_id',
        'course_code',
        'course_name'
    ];

    public function kuccpsApplicant(){

        return $this->belongsTo(KuccpsApplicant::class, 'id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\KuccpsApplicationFactory::new();
    }
}
