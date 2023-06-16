<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClusterSubject extends Model
{
    use HasFactory;
//    protected $table = 'cluster_subjects';

    protected $fillable = ['group_id', 'subject'];

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\ClusterSubjectFactory::new();
    }
}
