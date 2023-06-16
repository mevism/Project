<?php

namespace Modules\Examination\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [];

    
    public function processExams(){

        return $this->belongsTo(ExamMarks::class, 'id');
    }

  public function marksProcessed(){

        return $this->hasMany(ExamMarks::class, 'workflow_id');
    }

    
    protected static function newFactory()
    {
        return \Modules\Examination\Database\factories\ExamWorkflowFactory::new();
    }
}
