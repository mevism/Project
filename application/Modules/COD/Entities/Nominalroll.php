<?php

namespace Modules\COD\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Registrar\Entities\AcademicYear;
use Modules\Registrar\Entities\Student;

class Nominalroll extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['nominal_id', 'student_id', 'reg_number', 'year_study', 'semester_study', 'academic_year','academic_semester', 'pattern_id', 'class_code', 'registration', 'activation'];

    public function yearStudy(){

        return $this->belongsTo(AcademicYear::class, 'academic_year');
    }

    public function patternRoll(){

        return $this->belongsTo(Pattern::class, 'pattern_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\NominalrollFactory::new();
    }
}
