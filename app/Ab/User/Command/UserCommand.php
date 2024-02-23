<?php 

namespace App\Ab\User\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCommand
{

    public static function register($request) : void
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
 
    }


    public static function updateUserPassword($password, $email): void
    {
        $password = Hash::make($password);
        User::where('email', $email)->update(['password' => $password]);
    }


    
    
}