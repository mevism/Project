<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class STUDENTCOURSEVIEW extends Model
{
    use HasFactory;

    protected $table = 'STUDENTCOURSEVIEW';

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\STUDENTCOURSEVIEWFactory::new();
    }
}
