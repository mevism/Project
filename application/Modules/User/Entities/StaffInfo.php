<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffInfo extends Model
{
    use HasFactory;

    protected $primaryKey  =  'id';

    protected $fillable = ['user_id', 'staff_number', 'title', 'first_name', 'middle_name', 'last_name', 'gender', 'phone_number', 'office_email', 'personal_email'];
    
    protected static function newFactory()
    {
        return \Modules\User\Database\factories\StaffInfoFactory::new();
    }
}

