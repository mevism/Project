<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitProgramVersion extends Model
{
    use HasFactory;

    protected $fillable = ['course_code', 'version'];
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\UnitProgramVersionFactory::new();
    }
}
