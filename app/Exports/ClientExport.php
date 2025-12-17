<?php

namespace App\Exports;

use App\Models\ERP\AssignTask;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use MongoDB\BSON\ObjectId;

class ClientExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $data = $this->data;
        $collectData = [];
        foreach ($data as $key => $val) {
            $followupStatus = '';
            if (!empty($val->leadFollowupData) && count($val->leadFollowupData) > 0) {
                // Sort the array manually (since it's not an Eloquent relation)
                $sortedFollowups = collect($val->leadFollowupData)->sortByDesc('created_at')->values();
                $followupStatus = $sortedFollowups->first()['projectStatus'] ?? '';
            }
            $taskStatus = AssignTask::where('clientId', new ObjectId($val->_id))
                            ->orderBy('created_at', 'desc')
                            ->value('taskStatus');

            $collectData[] = [
                !empty($val->branches) ? $val->branches->branch_name : '',
                !empty($val->salseData) ? $val->salseData->name : '',
                $followupStatus,
                !empty($taskStatus) ? $taskStatus : '',
                !empty($val->operationTeam) ? $val->operationTeam->name : '',
                !empty($val->requestId) ? $val->requestId : '',
                !empty($val->requestName) ? $val->requestName : '',
                !empty($val->countryCode) ? $val->countryCode : '',
                !empty($val->phoneNo) ? $val->phoneNo : '',
                !empty($val->emailId) ? $val->emailId : '',
                !empty($val->city) ? $val->city : '',
                !empty($val->serviceCategory) ? $val->serviceCategory : '',
                !empty($val->requestLocation) ? $val->requestLocation : '',
                !empty($val->requestSellCountry) ? $val->requestSellCountry : '',
                !empty($val->comment) ? $val->comment : '',
                !empty($val->noteFromRequest) ? $val->noteFromRequest : '',
                !empty($val->jobTitle) ? $val->jobTitle : '',
                date('d/m/Y', strtotime($val->created_at))
            ];
        }
        
        return collect($collectData);
    }

    public function headings(): array
    {
        return [
            'Branch',
            'SalesPulse Person',
            'Follow Up',
            'Task Status',
            'Assigned To',
            'Request ID',
            'Requester Name',
            'Country Code',
            'Phone No',
            'Email ID',
            'City',
            'Service Category',
            'Requester Location',
            'Requester Sell in Country',
            'Comment',
            'Note From Requester',
            'Job Title',
            'Date',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Row 1 = headings
        ];
    }
}
