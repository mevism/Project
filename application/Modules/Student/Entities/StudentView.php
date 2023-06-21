<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\COD\Entities\Nominalroll;

class StudentView extends Model
{
    use HasFactory;

    protected $table = 'studentview';

    protected $fillable = [];

    public function studentRegistration(){
        return $this->hasMany(Nominalroll::class, 'student_id', 'student_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\StudentViewFactory::new();
    }
}
