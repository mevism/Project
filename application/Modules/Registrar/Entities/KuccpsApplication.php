<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\AdmissionApproval;
use function Symfony\Component\Translation\t;

class KuccpsApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'intake_id',
        'course_code',
        'course_name'
    ];

    public function kuccpsApplicant(){

        return $this->belongsTo(KuccpsApplicant::class, 'id');
    }

    public function kuccpsIntake(){

        return $this->belongsTo(Intake::class,'intake_id' );
    }

    public function approveKuccps(){

        return $this->hasOne(AdmissionApproval::class, 'app_id');
    }

    public function kuccpsAdmit(){
        return $this->hasOne(AdmissionApproval::class, 'user_id');
    }

    public function studentKuccps(){

        return $this->hasOne(AdmissionApproval::class, 'user_id');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\KuccpsApplicationFactory::new();
    }
}
