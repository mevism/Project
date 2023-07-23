<?php

namespace Modules\Administrator\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = "staffview";

    public function staffRole(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function Users(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    protected static function newFactory()
    {
        return \Modules\Administrator\Database\factories\StaffFactory::new();
    }
}
