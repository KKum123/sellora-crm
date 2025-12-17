<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class TeamFamilyInformations extends Model
{
    protected $collection = "crm_team_family_Inforamtions";
    protected $fillable = ['name','relationship','dateOfBirth','phone','employeeId'];
}
