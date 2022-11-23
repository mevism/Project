<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function feelevel(){
        return $this->hasOne(SemesterFee::class, 'id');
    }
    public function clmlevel(){
        return $this->hasOne(CourseLevelMode::class, 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\LevelFactory::new();
    }
}
