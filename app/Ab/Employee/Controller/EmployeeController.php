<?php

namespace App\Ab\Employee\Controller;

use App\Models\Employee;

use App\Ab\Employee\Querry\EmployeeQuerry;
use App\Ab\Employee\Command\EmployeeCommand;
use App\Ab\Employee\Request\AttendenceNewFormRequest;
use App\Ab\Employee\Request\EmployeeNewFormRequest;

use App\Jobs\SendAttendanceEmail;
use App\Ab\FileManager\Command\FileManagerCommand;


class EmployeeController
{

    private $queryHandler;
    private $commandHandler;

    public function __construct(EmployeeQuerry $queryHandler, EmployeeCommand $commandHandler)
    {
        $this->queryHandler =  $queryHandler;
        $this->commandHandler =     $commandHandler;
    }

    public function generateResponse($status, $message, $data = [])
    {

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }



    /**
     *  @OA\Get(
     *     path="/ab/v1/employee/all",
     *    summary="Get all employees",
     *   description="Get all employees",
     */
    public function index()
    {

        $employees = $this->queryHandler->index();
        return self::generateResponse($employees['status'], $employees['message'], $employees['data']);

    }


    /**
     *  @OA\Post(
     *     path="/ab/v1/employee/new",
     *    summary="Add new employee",
     *   description="Add new employee",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/EmployeeNewFormRequest")
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Employee Added"
     *   ),
     *   @OA\Response(
     *       response=400,
     *       description="Invalid data"
     *   ),
     *   @OA\Response(
     *       response=401,
     *       description="Unauthenticated"
     *   ),
     * 
     *  a 
     */
    public function store(EmployeeNewFormRequest $request)
    {

        $this->commandHandler->store($request);
        return self::generateResponse(200, 'Employee Added',);

    }


    /**
     *  @OA\Get(
     *     path="/ab/v1/employee/get/{id}",
     *    summary="Get employee by id",
     *   description="Get employee by id",
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Employee found"
     *   ),
     *   @OA\Response(
     *       response=404,
     *       description="Employee not found"
     *   )
     */
    public function show($id)
    {

        $employee = $this->queryHandler->show($id);
        return self::generateResponse($employee['status'], $employee['message'], $employee['data']);

    }


    /**
     *  @OA\Post(
     *     path="/ab/v1/employee/update/{id}",
     *    summary="Update employee",
     *   description="Update employee",
     *   @OA\RequestBody(
     *       required=true,
     *   ),
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Employee Updated"
     *   ),
     *   @OA\Response(
     *       response=404,
     *       description="Employee not found"
     *   )
     */
    public function update(EmployeeNewFormRequest $request, $id)
    {


        if ($this->queryHandler->show($id)['status'] == 404) {
            return self::generateResponse(404, 'Employee not found');
        } else {
            $employee = $this->commandHandler->update($request, $id);
            return self::generateResponse(200, 'Employee Updated');
        }
    }


    /**
     *  @OA\Post(
     *     path="/ab/v1/employee/delete/{id}",
     *    summary="Delete employee",
     *   description="Delete employee",
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Employee Deleted"
     *   ),
     *   @OA\Response(
     *       response=404,
     *       description="Employee not found"
     *   )
     */
    public function destroy($id)
    {

        if ($this->queryHandler->show($id)['status'] == 404) {
            return self::generateResponse(404, 'Employee not found');
        } else {

            $this->commandHandler->destroy($id);
            return self::generateResponse(200, 'Employee Deleted');
        }
    }


    /**
     *  @OA\Get(
     *     path="/ab/v1/employee/{id}/attendance/all",
     *    summary="Get all attendance of employee",
     *   description="Get all attendance of employee",
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Attendance found"
     *   ),
     *   @OA\Response(
     *       response=404,
     *       description="Employee not found"
     *   )
     */
    public function allAttendance($id)
    {


        if ($this->queryHandler->show($id)['status'] == 404) {
            return self::generateResponse(404, 'Employee not found');
        } else {

            $attendance =  $this->queryHandler->allAttendance($id);
            return self::generateResponse($attendance['status'], $attendance['message'], $attendance['data']);
        }
    }


    /**
     *  @OA\Post(
     *     path="/ab/v1/employee/{id}/attendance/new",
     *    summary="Add new attendance",
     *   description="Add new attendance",
     *   @OA\RequestBody(
     *       required=true,
     *   ),
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Attendance Added"
     *   ),
     *   @OA\Response(
     *       response=404,
     *       description="Employee not found"
     *   )
     */
    public function attendanceStore(AttendenceNewFormRequest $request, $id)
    {


        if ($this->queryHandler->show($id)['status'] == 404) {
            return self::generateResponse(404, 'Employee not found');
        } else {

            $this->commandHandler->attendanceStore($request, $id);
            return self::generateResponse(200, 'Attendance Added');
        }
    }



    /**
     *  @OA\Post(
     *     path="/ab/v1/employee/{id}/attendance/{attendanceId}",
     *    summary="Update attendance",
     *   description="Update attendance",
     *   @OA\RequestBody(
     *       required=true,
     *   ),
     *   @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="attendanceId",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *           type="integer"
     *       )
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Attendance Updated"
     *   ),
     *   @OA\Response(
     *       response=404,
     *       description="Employee not found"
     *   )
     */

    public function attendanceUpdate(AttendenceNewFormRequest $request, $id, $attendanceId)
    {

        $employee = $this->queryHandler->show($id);

        if ($employee['status'] == 404) {
            return self::generateResponse(404, 'Employee not found');
        } else {


            $employeeData = $employee['data'];
            if ($this->queryHandler->singleAttendance($attendanceId)['status'] == 404) {
                return self::generateResponse(404, 'No attendance found');
            } else {


                $this->commandHandler->attendanceUpdate($request, $attendanceId);

                SendAttendanceEmail::dispatch($employeeData);


                return self::generateResponse(200, 'Attendance Updated');
            }
        }
    }


  
    
    public function daylyAttendanceReportInPdf()
    {

       $attendance = $this->queryHandler->detailAttendanceReport();

        $report =  FileManagerCommand::generatePdf($attendance['data']);

        return self::generateResponse(200, 'Attendance Report', ['report' => $report]);
    }


    public function daylyAttendanceReportInExcel()
    {

        $attendance = $this->queryHandler->detailAttendanceReport();

        $report =  FileManagerCommand::generateExcel($attendance['data']);

        return self::generateResponse(200, 'Attendance Report', ['report' => $report]);
    }
}


//