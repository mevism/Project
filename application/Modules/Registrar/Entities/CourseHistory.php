<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseHistory extends Model
{
    use HasFactory;

    public function coursehistorydept(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\CourseHistoryFactory::new();
    }
}
