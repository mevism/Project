<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Department;
use Modules\Student\Entities\StudentCourse;
use Modules\Student\Entities\StudentView;

class AcademicLeavesView extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'academicleavesview';

    public function StudentsDepartment(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
    public function StudentsLeave(){
        return $this->belongsTo(StudentView::class, 'student_id', 'student_id');
    }
    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\AcademicLeavesViewFactory::new();
    }
}
