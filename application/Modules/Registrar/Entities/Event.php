<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function calender(){
        
        return $this->hasMany(CalenderOfEvents::class, 'id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\EventFactory::new();
    }
}
