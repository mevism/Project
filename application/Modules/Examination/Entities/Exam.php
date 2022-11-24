<?php

namespace Modules\Examination\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Student;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function student(){
        return $this->belongsTo(Student::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Examination\Database\factories\ExamFactory::new();
    }
}
