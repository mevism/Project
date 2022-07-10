<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Application;

class FinanceLog extends Model
{
    use HasFactory;

    protected $fillable = [];

//        public function appFinance(){
//            return $this->belongsTo(Application::class, 'id');
//        }
    protected static function newFactory()
    {
        return \Modules\Finance\Database\factories\FinanceLogFactory::new();
    }
}
