<?php

namespace Modules\Approval\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Approval\Entities\VerifyEmail;
use Modules\Approval\Entities\VerifyUser;

class Application extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected  $table = 'applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    use HasFactory;

    protected $fillable = [
        'amount', 'receipt', 'user_id', 'telephone', 'status', 'intake_name', 'attendance', 'year', 'academic_program', 'course', 'created_at', 'updated_at'
    ];

    protected static function newFactory()
    {
        return \App\database\factories\ApplicationFactory::new();
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function VerifyEmail(){

        return $this->hasOne('\Modules\Application\Entities\VerifyEmail', 'id');
    }

    public function VerifyUser(){

        return $this->hasOne('\Modules\Application\Entities\VerifyUser', 'id');
    }

}
