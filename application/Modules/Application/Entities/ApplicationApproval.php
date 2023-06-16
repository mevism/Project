<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationApproval extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'applicant_id', 'finance_status', 'invoice_number', 'cod_status', 'cod_comments', 'dean_status', 'dean_comments', 'registrar_status', 'registrar_comments', 'reg_number', 'admission_letter'];

    public function approveApplication(){
        return $this->belongsTo(Application::class, 'application_id', 'application_id');
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\ApplicationApprovalFactory::new();
    }
}
