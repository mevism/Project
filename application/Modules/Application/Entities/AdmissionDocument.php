<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdmissionDocument extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function admDocuments(){
        return $this->belongsTo(Application::class);
    }

    protected static function newFactory()
    {
        return \Modules\Application\Database\factories\AdmissionDocumentFactory::new();
    }
}
