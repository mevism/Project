<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [];

    //rlship beteen an intake and academic year
    public function intake(){

        return $this->hasMany(Intake::class, 'id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\AcademicYearFactory::new();
    }
}
