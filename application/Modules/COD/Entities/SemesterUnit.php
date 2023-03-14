<?php

namespace Modules\COD\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Workload\Entities\Workload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Lecturer\Entities\TeachingArea;

class SemesterUnit extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function allocateUnit(){

        return $this->hasOne(Workload::class, 'unit_id', 'id');
    }

    public function unitTeacher(){

        // return $this->belongsToMany(User::class, 'teaching_areas', 'unit_code', 'user_id');

        return $this->hasMany(TeachingArea::class, 'unit_code', 'unit_code');
    }


    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\SemesterUnitFactory::new();
    }
}
