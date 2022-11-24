<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClusterWeights extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','student_name','gender','citizenship','mean_grade','agp',
    'cw1','cw2','cw3','cw4','cw5','cw6','cw7','cw8','cw9','cw10','cw11','cw12','cw13','cw14','cw15','cw16'
    ,'cw17','cw18','cw19','cw20','cw21','cw22','cw23'];
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\ClusterWeightsFactory::new();
    }
}
