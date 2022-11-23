<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Classes;

class Progression extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function classProgress(){
        return $this->belongsTo(Classes::class, 'name');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\ProgressionFactory::new();
    }
}
