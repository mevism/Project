<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassPattern extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function pattern(){

        return $this->belongsTo(Pattern::class);
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\ClassPatternFactory::new();
    }
}
