<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Application;

class CODLog extends Model
{
    use HasFactory;

    protected $fillable = [];


//    public function appCOD(){
//
//        return $this->belongsTo(Application::class, 'id');
//    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\CODLogFactory::new();
    }
}
