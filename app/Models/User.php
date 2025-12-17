<?php
namespace App\Models;

use App\Models\ERP\Branch;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable; // Make sure this is imported

class User extends Eloquent implements Authenticatable
{   
    protected $collection = 'crm_users'; // MongoDB collection name

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'username',
        'status',
        'role',
        'show_password',
        'branchId',
        'employeeCode',
        'employeeIdCode'
    ];

    // Add any methods required for the Authenticatable contract

    public function getAuthIdentifierName()
    {
        return 'id'; // MongoDB id
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Returns the user's primary key
    }

    public function getAuthPassword()
    {
        return $this->password; // Returns the user's password
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
        return 'remember_token';
    }
    public function branch(){
        return $this->belongsTo(Branch::class, 'branchId','_id');
    }
}
