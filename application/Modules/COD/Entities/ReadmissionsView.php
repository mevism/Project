<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Student;
use Modules\Student\Entities\AcademicLeave;
use Modules\Student\Entities\StudentView;
use function Symfony\Component\Translation\t;

class ReadmissionsView extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'readmissionsview';

    public function StudentsReadmission(){
        return $this->belongsTo(StudentView::class, 'student_id', 'student_id');
    }

    public function ReadmissionClass(){
        return $this->hasOne(ReadmissionClass::class, 'readmission_id', 'readmision_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\ReadmissionsViewFactory::new();
    }
}
