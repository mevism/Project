<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Applicant;

class VerifyUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'verification_code'];

    public function verifyUser(){

        return $this->belongsTo(Applicant::class, 'user_id');
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\VerifyUserFactory::new();
    }

}
