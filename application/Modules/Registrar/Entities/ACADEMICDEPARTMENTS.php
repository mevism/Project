<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ACADEMICDEPARTMENTS extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'academicdepartments';

    public function deptDivision(){
        return $this->belongsTo(Division::class, 'division_id', 'division_id');
    }

    public function deptSchool(){
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\academicdepartmentsFactory::new();
    }
}
