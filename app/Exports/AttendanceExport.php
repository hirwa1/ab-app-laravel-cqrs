<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            
           
            'Employee Name',
            'Employee Email',
            'Employee ID',
            'Date',
            'Time In',
            'Time Out',
            'Total Hours',
            'Overtime',
            'Remarks',
            'Approved By',
            'Approved At'

        ];
    }
}
?>