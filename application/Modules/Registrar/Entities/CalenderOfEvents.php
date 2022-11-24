<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalenderOfEvents extends Model
{
    use HasFactory;

    protected $fillable = [];

     public function EventsIntake(){
        return $this->belongsTo(Intake::class, 'intake_id');
     }
    
    public function events(){
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function yearAcademic(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\CalenderOfEventsFactory::new();
    }
}
