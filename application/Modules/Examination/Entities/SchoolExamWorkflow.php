<?php

namespace Modules\Examination\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolExamWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'schoolexamworkflow';

    public function SchoolDeparmentalExams(){
        return $this->hasMany(ModeratedResults::class, 'exam_approval_id', 'exam_approval_id');
    }

    protected static function newFactory()
    {
        return \Modules\Examination\Database\factories\SchoolExamWorkflowFactory::new();
    }
}
