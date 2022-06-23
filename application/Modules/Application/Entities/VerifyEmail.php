<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Applicant;

class VerifyEmail extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'verification_code'];

    public function applicant(){

        return $this->belongsTo('\Modules\Application\Entities\Applicant', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\VerifyEmailFactory::new();

    }
}
