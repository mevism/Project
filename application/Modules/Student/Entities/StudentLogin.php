<?php

namespace Modules\Student\Entities;

use App\Http\Middleware\Student\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\COD\Entities\Nominalroll;

class StudentLogin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'student_logins';
    protected $fillable = [];

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

    public function loggedStudent(){
        return $this->belongsTo(StudentInfo::class, 'student_id', 'student_id');
    }

    public function enrolledCourse(){
        return $this->belongsTo(StudentCourse::class, 'student_id', 'student_id');
    }

    public function StudentAddresses(){
        return $this->belongsTo(StudentAddress::class, 'student_id', 'student_id');
    }

    public function StudentsContact(){
        return $this->belongsTo(StudentContact::class, 'student_id', 'student_id');
    }

    public function StudentsNominalRoll(){
        return $this->hasMany(Nominalroll::class, 'student_id', 'student_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\StudentLoginFactory::new();
    }
}
