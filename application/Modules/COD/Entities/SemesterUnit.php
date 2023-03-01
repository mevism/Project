<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Workload\Entities\Workload;

class SemesterUnit extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function allocateUnit(){

        return $this->hasOne(Workload::class, 'unit_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\SemesterUnitFactory::new();
    }
}
