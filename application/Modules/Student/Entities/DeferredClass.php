<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeferredClass extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function classDiferred(){

        return $this->belongsTo(AcademicLeave::class, 'leave_id', 'leave_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\DeferredClassFactory::new();
    }
}
