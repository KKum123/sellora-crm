<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class Department extends Model
{
    protected $collection = "crm_departments";
    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->hasMany(DepartmentPermission::class, 'departmentId', '_id')
                ->select('_id', 'parentId', 'childId');
    }
}
