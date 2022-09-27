<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;

    protected $fillable = ['applicant_id', 'institution', 'start_date', 'exit_date', 'level', 'qualification'];
    
    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\EducationFactory::new();
    }
}
