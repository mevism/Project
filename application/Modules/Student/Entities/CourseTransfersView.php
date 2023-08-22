<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Department;
use function Symfony\Component\Translation\t;

class CourseTransfersView extends Model
{
    use HasFactory;

    protected $fillable = [];
//    protected $dates = 'deleted_at';
    protected $table = 'coursestransferview';

    public function StudentsTransferCourse(){
        return $this->belongsTo(StudentCourse::class, 'student_id', 'student_id')->withTrashed();
    }

    public function CourseTransferDept(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function TransferCourse(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\CourseTransfersViewFactory::new();
    }
}
