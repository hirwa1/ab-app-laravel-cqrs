<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReset;

class SendRestPasswordEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   
    protected $email;
    protected $newPassword;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $newPassword)
    {
        $this->email = $email;
        $this->newPassword = $newPassword;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new PasswordReset('Your New Password', $this->newPassword));
    }
}
