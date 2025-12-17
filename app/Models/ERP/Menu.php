<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class Menu extends Model
{

    protected $collection = "crmMenu";

    public function routes()
    {
        return $this->hasMany(MenuRoute::class, 'parentId', '_id');
    }
}
