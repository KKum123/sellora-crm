<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class TeamExperience extends Model
{
    protected $collection = "crm_team_experiences";
    protected $fillable = ['companyName','joinDate','employeeId'];
}
