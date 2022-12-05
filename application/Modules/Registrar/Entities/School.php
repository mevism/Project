<?php

namespace Modules\Registrar\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function getUser(){

        return $this->hasMany(User::class, 'id');
    }

    public function departmenthistory(){

        return $this->hasMany(DepartmentHistory::class, 'id');
    }

    public function departments(){

        return $this->hasMany(Department::class, 'id');
    }

    public function Dept(){

        return $this->hasMany(Department::class, 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\SchoolFactory::new();
    }
}
