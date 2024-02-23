<?php


namespace App\Ab\User\Controller;

use App\Ab\User\Querry\UserQuerry;
use App\Ab\User\Command\UserCommand;
use App\Ab\User\Request\UserLoginFormRequest;
use App\Ab\User\Request\UserSignupFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Ab\User\Request\PasswordResetFormRequest;

use OpenApi\Annotations as OA;


use App\Jobs\SendRestPasswordEmail;

class UserController
{

    private $userQuerry;
    private $userCommand;



    public function __construct(UserQuerry $userQuerry, UserCommand $userCommand)
    {
        $this->userQuerry =  $userQuerry;
        $this->userCommand =     $userCommand;
    }


    public function generateResponse($status, $message, $data = [])
    {

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }


    public function index()
    {

        $user  = $this->userQuerry->index(Auth::user()->id);
        return self::generateResponse(200, 'User found', ['user' => $user]);
    }


    /**
     *  @OA\Get(
     *     path="/ab/v1/token",
     *    summary="Get user token",
     *   description="Get user token",
     */
    public function token()
    {

        $token = $this->userQuerry->token();
        return self::generateResponse(200, 'Token generated', ['token' => $token]);
    }




    /**
     * @OA\Post(
     *     path="/ab/v1/register",
     *     tags={"User"},
     *     summary="Register a new user",
     *     description="This can only be done by the logged in user.",
     *     operationId="createUser",
     *     @OA\RequestBody(
     *         description="Created user object",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *     )
     *  required={"name", "email", "password"},
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="The name of the user",
     *         example="John Doe"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         description="The email of the user",
     *         example="john.doe@example.com"
     *     ),
     *     @OA\Property(
     *         property="password",
     *         type="string",
     *         format="password",
     *         description="The password of the user",
     *         example="password123"
     *     )
     * )
     */
    public function register(UserSignupFormRequest $request)
    {

        $this->userCommand->register($request);
        return self::generateResponse(200, 'User registered');
    }



    /**
     * @OA\Post(
     *     path="/ab/v1/login",
     *     tags={"User"},
     *     summary="Logs user into the system",
     *    
     *     @OA\RequestBody(
     *         description="User login object",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username/password ",
     *     )
     * )
     */
    public function login(UserLoginFormRequest $request)
    {

        $token = $this->userQuerry->login($request);
        return self::generateResponse(200, 'User logged in', ['token' => $token]);
    }


    /**
     * @OA\Post(
     *     path="/ab/v1/logout",
     *     tags={"User"},
     *     summary="Logs out current logged in user session",
     *    
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *  
     * )
     */
    public function logout()
    {

        Auth::guard('web')->logout();
        return self::generateResponse(200, 'User logged out');
    }


    /**
     * @OA\Post(
     *     path="/user/forgot-password",
     *     tags={"User"},
     *     summary="Send reset password link to user email",
     *    
     *     @OA\RequestBody(
     *         description="User email object",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *     )
     * )
     */
    public function forgotPassword(PasswordResetFormRequest $request)
    {

        $user = $this->userQuerry->isUserExist($request->email);

        if (!$user) {
            return self::generateResponse(404, 'User not found');
        }

        $newPassword = $this->userQuerry->generateUserPasswordandEncrypt();
        $this->userCommand->updateUserPassword($newPassword, $request->email);


        /**
         *@OA\Post(
            *     path="ab/v1/forgot-password",


            *     @OA\RequestBody(
            *         description="User email object",
            *         required=true,
            *     ),
         */
        SendRestPasswordEmail::dispatch($request->email, $newPassword);

        return self::generateResponse(200, 'Password reset link sent');
    }
}
