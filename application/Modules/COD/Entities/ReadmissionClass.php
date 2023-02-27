<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Student\Entities\Readmission;

class ReadmissionClass extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function readmitClassReadmission(){
        return $this->belongsTo(Readmission::class, 'id');
    }
    
    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\ReadmissionClassFactory::new();
    }
}
