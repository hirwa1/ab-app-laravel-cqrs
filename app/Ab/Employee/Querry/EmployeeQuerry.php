<?php

namespace App\Ab\Employee\Querry;

use App\Models\Employee;
use App\Models\EmployeeAttendance;

use Illuminate\Http\Response;


class EmployeeQuerry
{

    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function index()
    {
        try {
            $employees = $this->employee->all();

            if ($employees->isEmpty()) {
                return [
                    'message' => 'No employee found',
                    'status' => Response::HTTP_NOT_FOUND,
                    'data' => []
                ];
            }

            return [
                'message' => 'Employee found',
                'status' => Response::HTTP_OK,
                'data' => $employees
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Server error',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error' => $e->getMessage()];
        }
    }


    public static function show($id){

        try {
            $employee = Employee::find($id);

            if (!$employee) {
                return [
                    'message' => 'Employee not found',
                    'status' => Response::HTTP_NOT_FOUND,
                    'data' => []
                ];
            }

            return [
                'message' => 'Employee found',
                'status' => Response::HTTP_OK,
                'data' => $employee
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Server error',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error' => $e->getMessage()];
        }
    }


    public static function allAttendance($id){

        try{
            $attendece = EmployeeAttendance::where('employee_id', $id)->get();

            if ($attendece->isEmpty()) {
                return [
                    'message' => 'No attendance found',
                    'status' => Response::HTTP_NOT_FOUND,
                    'data' => []
                ];
            }

            return [
                'message' => 'Attendance found',
                'status' => Response::HTTP_OK,
                'data' => $attendece
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Server error',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error' => $e->getMessage()];
        }
        


    }

    public static function singleAttendance($id){
            
            try{
                $attendece = EmployeeAttendance::find($id);
    
                if (!$attendece) {
                    return [
                        'message' => 'No attendance found',
                        'status' => Response::HTTP_NOT_FOUND,
                        'data' => []
                    ];
                }
    
                return [
                    'message' => 'Attendance found',
                    'status' => Response::HTTP_OK,
                    'data' => $attendece
                ];
            } catch (\Exception $e) {
                return [
                    'message' => 'Server error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'error' => $e->getMessage()];
            }
    }


    public static function detailAttendanceReport(){

        try{
            $attendece = EmployeeAttendance::whereDate('created_at', date('Y-m-d'))->get();

            if ($attendece->isEmpty()) {
                return [
                    'message' => 'No attendance found',
                    'status' => Response::HTTP_NOT_FOUND,
                    'data' => []
                ];
            }

        
            $attendece->map(function($item, $key){
                $employee = Employee::find($item->employee_id);
                $item->employee_name = $employee->name;
                $item->employee_email = $employee->email;
            });

            return [
                'message' => 'Attendance found',
                'status' => Response::HTTP_OK,
                'data' => $attendece
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Server error',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error' => $e->getMessage()];
        }


    }
}
