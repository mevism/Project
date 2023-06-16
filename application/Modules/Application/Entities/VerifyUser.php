<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Applicant;

class VerifyUser extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['applicant_id', 'verification_code'];

    public function userVerification(){

        return $this->hasOne(ApplicantLogin::class, 'applicant_id', 'applicant_id');
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\VerifyUserFactory::new();
    }

}
