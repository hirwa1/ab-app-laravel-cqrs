<?php

namespace App\Ab\FileManager\Command;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\Storage;


class FileManagerCommand
{


    public static function generateExcel($attendance): string
    {

        $data = [];
        foreach ($attendance as $attend) {

            $data[] = [
                'Employee Name' => $attend->employee_name,
                'Employee Email' => $attend->employee_email,
                'Employee ID' => $attend->employee_id,
                'Date' => $attend->date,
                'Time In' => $attend->time_in,
                'Time Out' => $attend->time_out,
                'Total Hours' => $attend->total_hours,
                'Overtime' => $attend->overtime,
                'Remarks' => $attend->remarks,
                'Approved By' => $attend->approved_by,
                'Approved At' => $attend->approved_at

            ];
        }

        $fileName = 'Attendance_' . date('Y-m-d') . '.xlsx';
        Excel::store(new AttendanceExport($data), $fileName, 'public');

        $file =  asset('storage/' . $fileName);

        return $file;
    }



    public static function generatePdf($attendance): string
    {
        $data = [];
        foreach ($attendance as $attend) {

            $data[] = [
                'Employee Name' => $attend->employee_name,
                'Employee Email' => $attend->employee_email,
                'Employee ID' => $attend->employee_id,
                'Date' => $attend->date,
                'Time In' => $attend->time_in,
                'Time Out' => $attend->time_out,
                'Total Hours' => $attend->total_hours,
                'Overtime' => $attend->overtime,
                'Remarks' => $attend->remarks,
                'Approved By' => $attend->approved_by,
                'Approved At' => $attend->approved_at
            ];
        }

        $view = view('pdf.attendance', ['data' => $data]);
        $pdf = PDF::loadHTML($view->render());

        $fileName = 'Attendance_' . date('Y-m-d') . '.pdf';

        Storage::put('public/' . $fileName, $pdf->output());


        $file =  asset('storage/' . $fileName);

        return $file;
    }
}
