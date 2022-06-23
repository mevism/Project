<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courses extends Model
{
    use HasFactory;

//    protected $fillable = ['campus_id'];
//    protected $guared = [];
//
//    protected $table = 'courses';
    protected $fillable = ['campus_id'];
    protected $guared = [];

    protected $table = 'courses';

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\CoursesFactory::new();
    }

    public function intakes(){
        $this->belongsTo(Intake::class, 'id');
    }
}
