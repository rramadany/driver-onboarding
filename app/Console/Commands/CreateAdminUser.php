<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Full Name');
        $email = $this->ask('Email Address');
        $password = $this->secret('Password');
        $passwordConfirmation = $this->secret('Confirm Password');

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
            'role' => 'admin', // Hard-code the role
        ];

        try {
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            if ($validator->fails()) {
                $this->error('Admin user creation failed!');
                foreach ($validator->errors()->all() as $error) {
                    $this->line($error);
                }
                return self::FAILURE; 
            }

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);

            $this->info('Administrator user created successfully!');
            return self::SUCCESS; 

        } catch (\Exception $e) {
            $this->error('An error occurred while creating the admin user.');
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }
}