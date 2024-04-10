<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

final class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Super Admin';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // check if User with id 1 exists
        if (User::find(1)) {
            $this->info('Super Admin already exists');

            return Command::SUCCESS;
        }

        $name = text('Enter your name', 'Super Admin', required: true);
        $email = text('Enter your email', required: true);
        $password = password('Enter your password', validate: fn (string $value) => match (true) {
            mb_strlen($value) < 8 => 'The password must be at least 8 characters.',
            default => null
        }, required: true);
        password('Confirm your password', validate: fn (string $value) => match (true) {
            mb_strlen($value) < 8 => 'The password must be at least 8 characters.',
            $value !== $password => 'The password confirmation does not match.',
            default => null
        }, required: true);

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->info('Super Admin created successfully');

        return Command::SUCCESS;
    }
}
