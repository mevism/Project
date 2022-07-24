<?php

namespace Modules\Approval\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    use HasFactory;
    protected $table = 'attendances';
}
