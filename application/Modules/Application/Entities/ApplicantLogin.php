<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Modules\Application\Entities\VerifyEmail;
use Modules\Application\Entities\VerifyUser;
use Laravel\Sanctum\HasApiTokens;

class ApplicantLogin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'username', 'password', 'phone_verification', 'student_type', 'email_verified_at'];

    public function VerifyEmail(){

        return $this->belongsTo(VerifyEmail::class, 'applicant_id', 'applicant_id');
    }

    public function applicantContact(){

        return $this->belongsTo(ApplicantContact::class, 'applicant_id', 'applicant_id');
    }

    public function VerifyUser(){

        return $this->belongsTo(VerifyUser::class, 'applicant_id', 'applicant_id');
    }

    public function infoApplicant(){

        return $this->hasOne(ApplicantInfo::class, 'applicant_id', 'applicant_id');
    }

    public function contactApplicant(){

        return $this->hasOne(ApplicantContact::class, 'applicant_id', 'applicant_id');
    }

    public function addressApplicant(){

        return $this->hasOne(ApplicantAddress::class, 'applicant_id', 'applicant_id');
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\ApplicantLoginFactory::new();
    }
}
