<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseClusterGroups extends Model
{
    use HasFactory;

    protected $fillable = ['group'];

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\CourseClusterGroupsFactory::new();
    }
}
