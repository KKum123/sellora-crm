<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class HRTrainingModel extends Model
{
   protected $collection = "crm_hrTraining";
   protected $fillable = ['trainingName','trainingMaterial','uploadPDF','uploadImage','uploadVideo','status','hrId','branchId'];
}
