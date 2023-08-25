<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicantAddress extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'town', 'address', 'postal_code'];

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\ApplicantAddressFactory::new();
    }
}
