<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\COD\Entities\Nominalroll;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $primaryKey = 'year_id';
    protected $keyType = 'string';

    //rlship beteen an intake and academic year
    public function intake(){

        return $this->hasMany(Intake::class, 'id');
    }

    public function entryYear(){

        return $this->hasMany(StudentCourse::class, 'id');

    }

    public function studyYear(){

        return $this->hasMany(Nominalroll::class, 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\AcademicYearFactory::new();
    }
}
