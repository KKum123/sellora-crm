<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeadExport implements FromCollection, WithHeadings, WithStyles
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
            $collectData[] = [
                !empty($val->branches) ? $val->branches->branch_name : '',
                !empty($val->assignedTeam) ? $val->assignedTeam->name : '',
                !empty($val->request_id) ? $val->request_id : '',
                !empty($val->requester_name) ? $val->requester_name : '',
                !empty($val->countryCode) ? $val->countryCode : '',
                !empty($val->phone) ? $val->phone : '',
                !empty($val->email) ? $val->email : '',
                !empty($val->city) ? $val->city : '',
                !empty($val->service_category) ? $val->service_category : '',
                !empty($val->requester_location) ? $val->requester_location : '',
                !empty($val->requester_sell_in_country) ? $val->requester_sell_in_country : '',
                !empty($val->comments) ? $val->comments : '',
                !empty($val->note_from_requester) ? $val->note_from_requester : '',
                !empty($val->job_title) ? $val->job_title : '',
                !empty($val->projectStatus) ? $val->projectStatus : "Pending",
                date('d/m/Y', strtotime($val->created_at))
            ];
        }
        
        return collect($collectData);
    }

    public function headings(): array
    {
        return [
            'Branch',
            'Sales Person',
            'Request ID',
            'Requester Name',
            'Country Code',
            'Phone No',
            'Email ID',
            'City',
            'Service Category',
            'Requester Location',
            'Requester Sell in Country',
            'Comments',
            'Note From Requester',
            'Job Title',
            'Lead Status',
            'Date'
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Row 1 = headings
        ];
    }
}
