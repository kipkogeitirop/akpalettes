<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

#[Signature('admin:make {email : Email address for the admin account}')]
#[Description('Create or promote an administrator account')]
class MakeAdminUser extends Command
{
    public function handle(): int
    {
        $email = mb_strtolower(trim((string) $this->argument('email')));

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->components->error('Enter a valid email address.');

            return self::FAILURE;
        }

        $user = User::query()->firstOrNew(['email' => $email]);
        $name = $user->exists ? $user->name : $this->ask('Administrator name');

        if (! is_string($name) || trim($name) === '') {
            $this->components->error('A name is required.');

            return self::FAILURE;
        }

        $password = $this->secret('Password (at least 12 characters)');

        if (! is_string($password) || mb_strlen($password) < 12 || $password !== $this->secret('Confirm password')) {
            $this->components->error('Passwords must match and be at least 12 characters long.');

            return self::FAILURE;
        }

        $user->forceFill([
            'name' => trim($name),
            'password' => Hash::make($password),
            'is_admin' => true,
        ])->save();

        $this->components->info("Administrator account ready for {$email}.");

        return self::SUCCESS;
    }
}
