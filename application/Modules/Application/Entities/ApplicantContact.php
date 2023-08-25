<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicantContact extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'email','alt_email', 'mobile', 'alt_mobile'];

    public function applicantLogin(){

        return $this->belongsTo(ApplicantLogin::class, 'applicant_id', 'applicant_id');
    }

    public function routeNotificationForAfricasTalking($notification)
    {
        return $this->mobile;
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\ApplicantContactFactory::new();
    }
}
