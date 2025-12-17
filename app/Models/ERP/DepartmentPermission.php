<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class DepartmentPermission extends Model
{
    protected $collection = 'crm_departmentPermission';
    
    protected $fillable = [
        'departmentId',
        'parentId',
        'childId',
    ];

   public function parentdata(){
    return $this->belongsTo(Menu::class, '_id', 'parent_id');
   }
}
