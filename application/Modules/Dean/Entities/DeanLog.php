<?php

namespace Modules\Dean\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Application;

class DeanLog extends Model
{
    use HasFactory;

    protected $fillable = [];

//    public function appDean(){
//
//        return $this->belongsTo(Application::class, 'id');
//    }

    protected static function newFactory()
    {
        return \Modules\Dean\Database\factories\DeanLogFactory::new();
    }
}
