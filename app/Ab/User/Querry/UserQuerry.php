<?php 

namespace App\Ab\User\Querry;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserQuerry
{




    public function token() : string
    {
      
        return  csrf_token();
    }

    public function index($id): User
    {
        return User::find($id);
    }

    public function login($request) : array
    {
        
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (!$user) {
            return ['message' => 'Email not found', 'status' => 404];
        }

        if (!Hash::check($password, $user->password)) {
            return ['message' => 'Incorrect password', 'status' => 401];
        }

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return ['message' => 'User login successfully', 'status' => 200, 'user' => $user];
        } else {
            return ['message' => 'User login failed', 'status' => 401];
        }
    }


    public static function isUserExist($email): bool
    {
        return User::where('email', $email)->exists();
    }


    public static function generateUserPasswordandEncrypt() : string
    {

     return  Str::random(12);
        
    }
}