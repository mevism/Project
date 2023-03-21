<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrar\Entities\Department;
use Spatie\Permission\Models\Role;

class UserEmployment extends Model
{
    use HasFactory;

    public function userplacement(){

        return $this->belongsTo(User::class);
    }

    public function userDepartment(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function userRole(){

        return $this->belongsTo(Role::class, 'role_id');
    }
}
