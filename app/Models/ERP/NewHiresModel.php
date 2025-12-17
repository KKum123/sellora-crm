<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class NewHiresModel extends Model
{
    protected $collection = "crm_newHires";
    protected $fillable = ['teamId','hrId','branchId'];
    
    public function hr(){
        return $this->belongsTo(Team::class, 'hrId','_id');
    }
    public function team(){
        return $this->belongsTo(Team::class, 'teamId','_id');
    }
}
