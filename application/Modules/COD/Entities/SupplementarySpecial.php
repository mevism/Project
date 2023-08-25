<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplementarySpecial extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function SupSpecialUnit(){
        return $this->belongsTo(Unit::class, 'unit_code', 'unit_code');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\SupplementarySpecialFactory::new();
    }
}
