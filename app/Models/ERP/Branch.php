<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;

class Branch extends Eloquent implements Authenticatable
{
    protected $collection = "crm_branches"; 
    protected $fillable = [
        'country', 'branch_name', 'branch_code', 'manager_name', 
        'email', 'mobile', 'complete_address', 'state', 'city', 
        'pincode', 'password', 'show_password', 'status', 'admin_id','role'
    ];
    //role = Branch / Sub Branch
    public function getAuthIdentifierName()
    {
        return 'id'; // MongoDB identifier name
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Primary key for MongoDB
    }

    public function getAuthPassword()
    {
        return $this->password; // Return the password field
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Remember token field name
    }
    public function team(){
        return $this->belongsTo(Team::class, 'branchId', '_id');
    }
}
