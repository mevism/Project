<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassPoints extends Model
{
    use HasFactory;

    protected $fillable = ['class_code', 'points'];

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\ClassPointsFactory::new();
    }
}
