<?php

namespace Modules\Examination\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Examination\Database\factories\ExamWorkflowFactory::new();
    }
}
