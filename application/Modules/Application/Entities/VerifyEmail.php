<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Applicant;

class VerifyEmail extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = ['applicant_id', 'verification_code'];

    public function emailVerify(){

        return $this->hasOne(ApplicantInfo::class, 'applicant_id', 'applicant_id');
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\VerifyEmailFactory::new();

    }
}
