<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\CampusFactory::new();
    }
}
