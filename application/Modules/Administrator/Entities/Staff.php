<?php

namespace Modules\Administrator\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $connection = "sqlsrv";
    protected $table = "VIEWSTAFFACTIVE";

    protected static function newFactory()
    {
        return \Modules\Administrator\Database\factories\StaffFactory::new();
    }
}
