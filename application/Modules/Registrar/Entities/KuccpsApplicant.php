<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KuccpsApplicant extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'index_number', 'surname', 'first_name', 'middle_name', 'gender', 'mobile', 'alt_mobile', 'email', 'alt_email', 'box', 'postal_code', 'town', 'course_name', 'course_code', 'level', 'institution', 'qualification', 'start_date', 'exit_date', 'intake_id'];
    protected $primaryKey = 'applicant_id';
    protected $keyType = 'string';

    public function kuccpsApplication(){
        return $this->hasOne(KuccpsApplication::class, 'applicant_id', 'applicant_id');
    }

    public function GovIntake(){
        return $this->belongsTo(Intake::class, 'intake_id', 'intake_id');
    }
    public function GovCourses(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\KuccpsApplicantFactory::new();
    }
}
