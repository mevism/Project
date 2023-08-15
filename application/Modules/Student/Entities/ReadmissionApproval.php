<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReadmissionApproval extends Model
{
    use HasFactory;

    protected $fillable = ['approval_id', 'readmission_id', 'cod_status', 'cod_remarks', 'cod_user_id', 'readmission_class', 'readmission_year', 'readmission_semester'];

    public function approvedReadmission(){

        return $this->belongsTo(Readmission::class, 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\ReadmissionApprovalFactory::new();
    }
}
