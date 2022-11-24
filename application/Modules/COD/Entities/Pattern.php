<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pattern extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['season_code', 'season'];

    public function classPattern(){

        return $this->hasMany(ClassPattern::class);
    }

    public function nominalPattern(){

        return $this->hasMany(Nominalroll::class);
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\PatternFactory::new();
    }
}
