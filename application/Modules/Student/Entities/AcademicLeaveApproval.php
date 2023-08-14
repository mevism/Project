<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicLeaveApproval extends Model
{
    use HasFactory;

    protected $fillable = ['leave_id', 'cod_status', 'cod_remarks', 'cod_user_id', 'leave_approval_id'];

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\AcademicLeaveApprovalFactory::new();
    }
}
