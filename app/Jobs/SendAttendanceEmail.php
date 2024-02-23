<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

use App\Mail\AttendanceAdded;


class SendAttendanceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    
     private $employeeData;

     public function __construct($employeeData)
     {
         $this->employeeData = $employeeData;
     }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->employeeData->email)->send(new AttendanceAdded($message = 'Your Attendance Updated', $name = $this->employeeData->name));

    }
}
