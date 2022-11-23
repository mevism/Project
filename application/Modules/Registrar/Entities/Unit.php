<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['colSubjectId','colSubjectName'];
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\UnitFactory::new();
    }
}
