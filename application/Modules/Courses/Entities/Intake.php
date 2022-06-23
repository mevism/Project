<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Intake extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\IntakeFactory::new();
    }

    public function scopeFilter($query, array $filter){
        if($filter['search'] ?? false){
            $query->where('intake_name','LIKE','%'.request('search').'%')->orWhere('course_id','LIKE','%'.request('search').'%');
        }

    }

//    public function available()
//    {
//        return $this->hasMany(\Modules\Courses\Entities\AvailableCourse::class, 'intake_id');
//    }
    public function available()
    {
        return $this->hasMany('\Modules\Courses\Entities\AvailableCourse', 'intake_id');
    }

    public function courses(){
        $this->hasOne(Courses::class, 'id');
    }

}
