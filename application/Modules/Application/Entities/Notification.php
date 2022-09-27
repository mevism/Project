<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function appNotification(){

        return $this->belongsTo(Application::class);

    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\NotificationFactory::new();
    }
}
