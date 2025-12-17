<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Country extends Eloquent
{
    protected $collection = 'crm_countries'; 
    protected $fillable = ['name']; 
}
