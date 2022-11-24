<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\SemesterFee;

class VoteHead extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function feeVotehead(){

        return $this->hasMany(SemesterFee::class, 'id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\VoteHeadFactory::new();
    }
}
