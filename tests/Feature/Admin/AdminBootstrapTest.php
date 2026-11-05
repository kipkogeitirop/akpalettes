<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminBootstrapTest extends TestCase
{
    public function test_console_command_creates_an_admin_with_a_hashed_password(): void
    {
        $this->artisan('admin:make', ['email' => 'studio@example.com'])
            ->expectsQuestion('Administrator name', 'Studio Admin')
            ->expectsQuestion('Password (at least 12 characters)', 'MySecurePassword123!')
            ->expectsQuestion('Confirm password', 'MySecurePassword123!')
            ->assertExitCode(0);

        $admin = User::query()->where('email', 'studio@example.com')->firstOrFail();

        $this->assertModelExists($admin);
        $this->assertTrue($admin->is_admin);
        $this->assertTrue(Hash::check('MySecurePassword123!', $admin->password));
    }
}
