<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Applicant;

class VerifyEmail extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'verification_code'];

    public function userEmail(){

        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\VerifyEmailFactory::new();

    }
}
