<?php

namespace Modules\Lecturer\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\COD\Entities\Unit;
use Modules\Registrar\Entities\UnitProgramms;

class TeachingArea extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function teachingArea(){
        return $this->belongsTo(Unit::class, 'unit_code', 'unit_code');
    }
    public function userTeachingArea(){

         return $this->belongsTo(User::class, 'user_id');
    }
    public function userAreas(){

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getTeachingAreaRemarks(){
        return $this->hasMany(TeachingAreaRemarks::class, 'teaching_id', 'id');
     }
    protected static function newFactory()
    {
        return \Modules\Lecturer\Database\factories\TeachingAreaFactory::new();
    }
}

