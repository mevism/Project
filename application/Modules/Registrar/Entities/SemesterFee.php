<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\VoteHead;
use PhpParser\Node\Expr\Cast;

class SemesterFee extends Model
{
    use HasFactory;

    protected $fillable = ['votehead_id','semesterI', 'semesterII', 'attendance_id', 'course_level_mode_id', 'semester_fee_id'];

    public function semVotehead(){

        return $this->belongsTo(VoteHead::class, 'votehead_id', 'votehead_id');
    }

    public function proformaInvoice(){

        return $this->belongsTo(CourseLevelMode::class, 'course_level_mode_id', 'course_level_mode_id');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\SemesterFeeFactory::new();
    }

}
