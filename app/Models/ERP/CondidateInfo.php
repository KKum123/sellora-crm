<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class CondidateInfo extends Model
{
    protected $connectin = "crm_condidateInfo";
    protected $fillable = ['candidateName','jobProfile','mobile','totalExperience','address','interviewDate','offeredSalary','otherDescription','hrId','interviewStatus','chnageStatuByHrId'];
}
