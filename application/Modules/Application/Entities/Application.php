<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'receipt', 'user_id', 'telephone', 'status', 'intake_name', 'attendance', 'year', 'academic_program', 'course', 'created_at', 'updated_at'
    ];

    public function applicant(){

       return $this->belongsTo(Applicant::class, 'user_id');
    }

    protected static function newFactory()
    {
        return \database\factories\ApplicationFactory::new();
    }
}
