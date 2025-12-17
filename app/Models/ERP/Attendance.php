<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;
class Attendance extends Model
{
    protected $collection = 'crm_attendance';
    protected $fillable = ['adminId','branchId','teamId','goodMoringDateTime','goodNightDateTime','goodNightMessage','updateByHrId','hrRemarks','correctionDateTime',
            'userIpGoodNight','userIpGoodMorning'
        ];

}
