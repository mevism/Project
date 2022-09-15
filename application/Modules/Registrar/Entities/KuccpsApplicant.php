<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KuccpsApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'index_number', 'sname', 'fname', 'mname', 'gender', 'mobile', 'alt_mobile', 'email', 'alt_email', 'BOX',
        'postal_code', 'town', 'school'
    ];


    public function kuccpsApplication(){

        return $this->hasOne(KuccpsApplication::class, 'applicant_id');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\KuccpsApplicantFactory::new();
    }
}
