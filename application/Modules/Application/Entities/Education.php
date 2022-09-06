<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function applicantSchool(){
        return $this->belongsTo(Applicant::class);
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\EducationFactory::new();
    }
}
