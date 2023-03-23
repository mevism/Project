<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Lecturer\Entities\LecturerQualification;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\Division;
use Modules\Workload\Entities\Workload;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'app_id', 'index_number,', 'id_number', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $guard_name = 'user';

    public function getDept(){

        return $this->belongsTo(\Modules\Registrar\Entities\Department::class, 'department_id');

    }

    public function roles(): BelongsToMany {

        return $this->belongsToMany(Role::class, 'user_employments', 'user_id', 'role_id');
    }

    public function placedUser(){

       return $this->hasMany(UserEmployment::class);
    }

    public function getSch(){
        return $this->belongsTo(\Modules\Registrar\Entities\School::class, 'school_id');
    }

    public function employmentDivision(): BelongsToMany {

        return $this->belongsToMany(Division::class, 'user_employments', 'user_id', 'division_id');
    }

    public function employmentDepartment(): BelongsToMany {

        return $this->belongsToMany(Department::class, 'user_employments', 'user_id', 'department_id');
    }

    public function employmentStation(): BelongsToMany {

        return $this->belongsToMany(Department::class, 'user_employments', 'user_id', 'station_id');
    }

    public function workloadAllocation(){

        return $this->hasMany(Workload::class, 'user_id', 'id');
    }

    public function teachingAreaUser(){

        return $this->hasMany(TeachingArea::class, 'user_id','id');
    }

    public function lecturerQualfs(){

        return $this->hasMany(LecturerQualification::class, 'user_id', 'id');
    }

    public function lecturerQualification(){
        return $this->hasMany(LecturerQualification::class, 'user_id', 'id');
    }
}
