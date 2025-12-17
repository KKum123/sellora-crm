<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class TeamEducationInformations extends Model
{
    protected $collection = "crm_team_education_informations";
    protected $fillable = ['employeeId','collegeName','streem','fromDate','toDate'];
}
