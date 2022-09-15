<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Student;
use Modules\Registrar\Entities\StudentCourse;

class Nominalroll extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function nominal(){

        return $this->belongsTo(Student::class);

    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\NominalrollFactory::new();
    }
}
