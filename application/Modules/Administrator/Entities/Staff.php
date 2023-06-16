<?php

namespace Modules\Administrator\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = "STAFFVIEW";

    public function staffRole(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Administrator\Database\factories\StaffFactory::new();
    }
}
