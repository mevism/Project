<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Readmission extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function readmissionApproval(){

        return $this->hasOne(ReadmissionApproval::class, 'readmission_id');
    }

    public function leaves(){

        return $this->belongsTo(AcademicLeave::class, 'leave_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\ReadmissionFactory::new();
    }
}
