<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrar\Entities\VoteHead;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChargeableVotehead extends Model
{
    use HasFactory;

    protected $fillable = ['chargeable_vote_id', 'vote_id', 'amount', 'level', 'version'];
    

    public function voteheads()
    {
        return $this->belongsTo(VoteHead::class, 'vote_id', 'vote_id');
    }
    protected static function newFactory()
    {
        return \Modules\Finance\Database\factories\ChargeableVoteheadFactory::new();
    }
}
