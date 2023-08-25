<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationSubject extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'subject_1', 'subject_2', 'subject_3', 'subject_4'];

    protected $primaryKey = 'application_id';
    protected $keyType = 'string';
    
    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\ApplicationSubjectFactory::new();
    }
}
