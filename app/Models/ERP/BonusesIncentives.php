<?php

namespace App\Models\ERP;


use Jenssegers\Mongodb\Eloquent\Model;
class BonusesIncentives extends Model
{
    protected $collection = "crm_bonusesIncentives";
    protected $fillable = ['employeeId','branchId','hrId','bonusOrIncentiveType','bonusOrIncentiveAmount'];

    public function employee(){
        return $this->belongsTo(Team::class, 'employeeId', '_id');
    }
}
