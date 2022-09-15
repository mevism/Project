<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Application;
use Modules\COD\Entities\Nominalroll;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function studentCourse(){

        return $this->hasMany(StudentCourse::class);
    }

    public function signNominal(){

        return $this->hasMany(Nominalroll::class);

    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\StudentFactory::new();
    }
}
