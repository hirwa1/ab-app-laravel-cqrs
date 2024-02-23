<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Ab\User\Querry\UserQuerry;
use App\Models\User;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bootstrapLaravel();
    }

    protected function bootstrapLaravel()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
        $app['session']->start();

    }


    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function testTokenGeneration()
    {
        $userQuerry = new UserQuerry();
        $token = $userQuerry->token();

        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }

    /**
     * Test user retrieval by ID.
     *
     * @return void
     */
    public function testUserRetrievalById()
    {
        $user = User::factory()->create();
        $userQuerry = new UserQuerry();
        $retrievedUser = $userQuerry->index($user->id);

        $this->assertInstanceOf(User::class, $retrievedUser);
        $this->assertEquals($user->id, $retrievedUser->id);
    }

    /**
     * Test user login functionality.
     *
     * @return void
     */
    public function testUserLogin()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => Hash::make($password)]);
        $request = (object) ['email' => $user->email, 'password' => $password];

        $userQuerry = new UserQuerry();
        $loginResult = $userQuerry->login($request);

        $this->assertEquals(200, $loginResult['status']);
        $this->assertEquals($user->email, $loginResult['user']->email);
        $this->assertTrue(Auth::check());
    }

    /**
     * Test user login with incorrect password.
     *
     * @return void
     */
    public function testUserLoginWithIncorrectPassword()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $request = (object) ['email' => $user->email, 'password' => 'incorrectpassword'];

        $userQuerry = new UserQuerry();
        $loginResult = $userQuerry->login($request);

        $this->assertEquals(401, $loginResult['status']);
        $this->assertFalse(Auth::check());
    }

    /**
     * Test user login with non-existent email.
     *
     * @return void
     */
    public function testUserLoginWithNonExistentEmail()
    {
        $request = (object) ['email' => 'nonexistent@example.com', 'password' => 'password'];

        $userQuerry = new UserQuerry();
        $loginResult = $userQuerry->login($request);

        $this->assertEquals(404, $loginResult['status']);
        $this->assertFalse(Auth::check());
    }

    /**
     * Test user existence check.
     *
     * @return void
     */
    public function testUserExistenceCheck()
    {
        $user = User::factory()->create();
        $email = $user->email;

        $this->assertTrue(UserQuerry::isUserExist($email));
    }

    /**
     * Test user password generation and encryption.
     *
     * @return void
     */
    public function testUserPasswordGenerationAndEncryption()
    {
        $password = UserQuerry::generateUserPasswordandEncrypt();

        $this->assertNotEmpty($password);
        $this->assertIsString($password);
    }


    
}
