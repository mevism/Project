<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\KuccpsApplication;
use Modules\Registrar\Entities\Student;

class AdmissionApproval extends Model
{
    use HasFactory;

    protected $fillable = ['application_id'];

    public function appApprovals(){

        return $this->belongsTo(Application::class, 'application_id');

    }
    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\AdmissionApprovalFactory::new();
    }
}
