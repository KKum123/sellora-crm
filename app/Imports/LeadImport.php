<?php

namespace App\Imports;

use App\Models\ERP\Branch;
use App\Models\ERP\Lead;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;
use MongoDB\BSON\UTCDateTime;

class LeadImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $branchId = null;
        // $rows->shift(); // skips first row (heading)
        $createdTeamId = null;
        $createdBranchId = null;

        if (session()->has('branch') && session('branch')->_id) {
            $branchId = new ObjectId(session('branch')->_id);
            $createdBranchId = $branchId;
        } elseif (session()->has('team') && session('team')->branchId) {
            $branchId = new ObjectId(session('team')->branchId);
            $createdTeamId = new ObjectId(session('team')->_id);
        }
        
        if (!$branchId) return;
        
        $branchData = Branch::where('_id', $branchId)->first();
        // dd($branchData);
        if (!$branchData) return;

        $leadCount = Lead::count();
        $insertData = [];
       
        foreach ($rows as $index => $row) {
            if (empty($row['request_name'])) continue;
           
            $slrId = 'SLR0' . str_pad($leadCount + $index + 1, 4, '0', STR_PAD_LEFT);
           

            $insertData[] = [
                'country'                      => $branchData->country,
                'branch'                       => new ObjectId($branchData->_id),
                'request_id'                   => $slrId,
                'requester_name'               => $row['request_name'] ?? '',
                'countryCode'                  => $row['country_code'] ?? '',
                'phone'                        => $row['phone'] ?? '',
                'email'                        => $row['email'] ?? '',
                'city'                         => $row['city'] ?? '',
                'service_category'             => $row['service_category'] ?? '',
                'requester_location'           => $row['requester_location'] ?? '',
                'requester_sell_in_country'    => $row['requester_sell_in_country'] ?? '',
                'assign_to_sales'              => null,
                'comments'                     => $row['comments'] ?? '',
                'note_from_requester'          => $row['note_from_requester'] ?? '',
                'job_title'                    => $row['job_title'] ?? '',
                'status'                       => "1",
                'admin_id'                     => null,
                'branch_id'                    => $branchId,
                'team_id'                      => null,
                'careatedTeamId'                => $createdTeamId,
                'createdBranchId'              => $createdBranchId,
                'projectStatus'                => null,
                'unassignTeamId'               => null,
                'created_at'                   => new UTCDateTime(Carbon::now()),
                'updated_at'                   => new UTCDateTime(Carbon::now())
            ];
        }
      
        if (!empty($insertData)) {
            Lead::insert($insertData); // Bulk insert for speed
        }
    }
}
