<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseTransferApproval extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function transferApproval(){

        return $this->belongsTo(CourseTransfer::class, 'course_transfer_id')->withTrashed();
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\CourseTransferApprovalFactory::new();
    }
}
