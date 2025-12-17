<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class Designation extends Model
{
    protected $collection = "crm_designations";
    protected $fillable = ['name','departmentId'];
}
