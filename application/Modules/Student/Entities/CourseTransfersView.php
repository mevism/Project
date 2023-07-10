<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTransfersView extends Model
{
    use HasFactory;

    protected $fillable = [];
//    protected $dates = 'deleted_at';
    protected $table = 'coursetransfersview';

    public function StudentsTransferInfo(){
        return $this->belongsTo(StudentInfo::class, 'student_id', 'student_id');
    }

    public function StudentsTransferCourse(){
        return $this->belongsTo(StudentCourse::class, 'student_id', 'student_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\CourseTransfersViewFactory::new();
    }
}
