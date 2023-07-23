<?php

namespace Modules\Examination\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Department;

class ExamWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function DepartmentExams(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function ExamsWorkflows(){
        return $this->hasMany(ExamMarks::class, 'exam_approval_id', 'exam_approval_id');
    }

    public function ExamDepartment(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function DepartmentalResults(){
        return $this->hasMany(ModeratedResults::class, 'exam_approval_id', 'exam_approval_id');
    }

    protected static function newFactory()
    {
        return \Modules\Examination\Database\factories\ExamWorkflowFactory::new();
    }
}
