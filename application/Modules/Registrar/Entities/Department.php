<?php

namespace Modules\Registrar\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function getUser(){
        return $this->hasMany(User::class, 'id');
    }

    public function schools(){

        return $this->belongsTo(School::class, 'school_id');
    }

    public function getDeptCourse(){

        return $this->hasMany(Courses::class, 'id');
    }

    public function Sch(){

        return $this->belongsTo(School::class, 'school_id');
    }

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\DepartmentFactory::new();
    }
}
