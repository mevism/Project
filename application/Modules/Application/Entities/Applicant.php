<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Application\Entities\VerifyEmail;
use Modules\Application\Entities\VerifyUser;

class Applicant extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected  $table = 'applicants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'app_id', 'index_number', 'name', 'phone_verification'
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



    public function application(){

       return $this->hasMany(Application::class);
    }

    public function School(){
        return $this->hasMany(Education::class);
    }


    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\ApplicantFactory::new();
    }

}
