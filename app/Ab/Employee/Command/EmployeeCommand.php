<?php 

namespace App\Ab\Employee\Command;

use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Str;


class EmployeeCommand
{

    public static function store($request){

        $newEmployee = new Employee();


        $newEmployee->name = $request->name;
        $newEmployee->email = $request->email;
        $newEmployee->employeeIdentifier = 'EMP-'. Str::random(8);
        $newEmployee->phoneNumber = $request->phoneNumber;
        $newEmployee->address = $request->address;
        $newEmployee->position = $request->position;
        $newEmployee->department = $request->department;
        $newEmployee->salary = $request->salary;
        $newEmployee->status = $request->status;
        $newEmployee->save();
    }



    public static  function update($request, $id): void
    {
        $employee = Employee::find($id);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phoneNumber = $request->phoneNumber;
        $employee->address = $request->address;
        $employee->position = $request->position;
        $employee->department = $request->department;
        $employee->salary = $request->salary;
        $employee->status = $request->status;
        $employee->save();
    }


    public static function destroy($id): void
    {
        $employee = Employee::find($id);
        $employee->delete();
    }


    public static function attendanceStore($request, $id) : void
     {

       

        $attendance = new EmployeeAttendance();
        $attendance->employee_id = $id;
        $attendance->date = $request->date;
        $attendance->time_in = $request->time_in;
        $attendance->time_out = $request->time_out;
        $attendance->total_hours = $request->total_hours;
        $attendance->overtime = $request->overtime;
        $attendance->remarks = $request->remarks;
        $attendance->approved_by = $request->approved_by;
        $attendance->approved_at = $request->approved_at;

        $attendance->save();

    }

    public static function attendanceUpdate($request, $id) : void
    {
        $attendance = EmployeeAttendance::find($id);
        $attendance->date = $request->date;
        $attendance->time_in = $request->time_in;
        $attendance->time_out = $request->time_out;
        $attendance->total_hours = $request->total_hours;
        $attendance->overtime = $request->overtime;
        $attendance->remarks = $request->remarks;
        $attendance->approved_by = $request->approved_by;
        $attendance->approved_at = $request->approved_at;

        $attendance->save();
    }
    
    
}