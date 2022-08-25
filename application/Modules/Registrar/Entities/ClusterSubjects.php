<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClusterSubjects extends Model
{
    use HasFactory;

    protected $fillable = ['group1'];
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\ClusterSubjectsFactory::new();
    }
}
