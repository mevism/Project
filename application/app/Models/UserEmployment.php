<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrar\Entities\Department;
use Spatie\Permission\Models\Role;

class UserEmployment extends Model
{
    use HasFactory;

    protected $primaryKey  =  'id';

    public function userplacement(){

        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function userDepartment(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function userRole(){

        return $this->belongsTo(Role::class, 'role_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

}
