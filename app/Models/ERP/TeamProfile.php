<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class TeamProfile extends Model
{
    protected $collection = 'crm_team_profiles';
    protected $fillable = ['passportNo','passportExpDate','tel','nationality','religion','maritalstatus','employmentOfSpouse','noOfChildren',
    'primaryName','primaryRelationship','primaryPhone','secondaryName','secondaryRelationship','secondaryPhone',
    'bankName','bankAccountNo','IFSCCode','panNo','employeeId','maritalStatus'
    ];

    
}
