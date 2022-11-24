<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\VoteHead;
use PhpParser\Node\Expr\Cast;

class SemesterFee extends Model
{
    use HasFactory;

    protected $fillable = ['voteheads_id','semesterI', 'semesterII', 'attendance_id', 'course_level_mode_id'];

    public function semVotehead(){

        return $this->belongsTo(VoteHead::class, 'voteheads_id');
    }

    public function proformaInvoice(){

        return $this->belongsTo(CourseLevelMode::class);
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\SemesterFeeFactory::new();
    }

}
