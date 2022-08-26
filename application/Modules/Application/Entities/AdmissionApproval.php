<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\KuccpsApplication;
use Modules\Registrar\Entities\Student;

class AdmissionApproval extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function appApproval(){

        return $this->belongsTo(Application::class, 'id');
    }

    public function appApprovals(){

        return $this->hasOne(Application::class, 'app_id');
    }

    public function kuccpsApproval(){

        return $this->belongsTo(KuccpsApplication::class, 'user_id');
    }

    public function admitKuccps(){
        return $this->belongsTo(KuccpsApplication::class, 'app_id');
    }

    public function kuccpsStudent(){

        return $this->belongsTo(KuccpsApplication::class, 'app_id');
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\AdmissionApprovalFactory::new();
    }
}
