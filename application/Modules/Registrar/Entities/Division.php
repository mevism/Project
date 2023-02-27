<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function divisionDepts(){

        return $this->hasMany(Department::class);
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\DivisionFactory::new();
    }
}
