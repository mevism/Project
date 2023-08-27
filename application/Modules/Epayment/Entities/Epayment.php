<?php

namespace Modules\Epayment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Epayment extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['student_id', 'username', 'student_email', 'student_name', 'phone_number', 'password'];

    protected static function newFactory()
    {
        return \Modules\Epayment\Database\factories\EpaymentFactory::new();
    }
}
