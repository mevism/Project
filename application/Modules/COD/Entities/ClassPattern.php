<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Classes;

class ClassPattern extends Model
{
    use HasFactory;

    protected $fillable = [];
    //    protected $primaryKey = 'class_code';
    //    protected $primaryKey = 'name';
    protected $primaryKey = 'class_pattern_id';
    protected $keyType = 'string';

    public $incrementing = false;


    public function pattern()
    {

        return $this->belongsTo(Pattern::class);
    }

    public function classSchedule()
    {

        return $this->belongsTo(Classes::class, 'class_code', 'name');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\ClassPatternFactory::new();
    }
}
