<?php

namespace Tests\Unit\Ab\User\Command;

use App\Ab\User\Command\UserCommand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $userData = (object) [
            'name' => 'Test User', // Provide a valid name
            'email' => 'test@example.com',
            'password' => 'password',
        ];
    
        $userCommand = new UserCommand();
        $userCommand->register($userData);
    
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Test user password update.
     *
     * @return void
     */
    public function testUserPasswordUpdate()
    {
        $user = User::factory()->create(['password' => Hash::make('oldpassword')]);
        $newPassword = 'newpassword';

        $userCommand = new UserCommand();
        $userCommand->updateUserPassword($newPassword, $user->email);

        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    }
}
