<?php

namespace Modules\Hello\Tests\Unit\Console;

use Tests\TestCase;


class HelloConsoleTest extends TestCase
{
    /**
     * @test
     */
    public function handle_should_create_a_new_user_with_account_assignment(): void
    {
        $userData = [
            'email' => 'test@test.com',
            'name' => 'Test User',
            'role' => $this->role->name,
            '--account-id' => [$this->account->id],
        ];

        $this->artisan('auth:create-user', $userData)
            ->assertExitCode(0);

        $user = User::first();

        $this->assertEquals(1, User::count());
        $this->assertEquals($userData['--account-id'][0], $user->accounts[0]->id);
    }
}