<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\LeadImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class BulkUploadControllers extends Controller
{
    public function bulkUploadLead(Request $req){
        
        if ($req->hasFile('fileToUpload')) {    
            $req->validate([
                'fileToUpload' => 'required|file|mimes:xlsx,xls'
            ]);
        
            // DB::beginTransaction();
            // try {
            
                Excel::import(new LeadImport, $req->file('fileToUpload'));
                
            //     DB::commit();
            // } catch (\Exception $e) {
            //     DB::rollBack();
            // }
    
            return response()->json([
                'success' => true,
                'message' => 'Excel imported  successfully'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No file uploaded',
            ], 400);
        }

        
    
    }
}
