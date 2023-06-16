<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicantInfo extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'fname', 'mname', 'sname', 'gender', 'index_number'];

    public function applicantInfo(){

        return $this->belongsTo(ApplicantLogin::class, 'applicant_id', 'applicant_id');
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\ApplicantInfoFactory::new();
    }
}
