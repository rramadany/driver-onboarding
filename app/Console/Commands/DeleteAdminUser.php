<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DeleteAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an admin user by email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Enter the email address of the admin user to delete');

        if (empty($email)) {
            $this->error('Email address cannot be empty.');
            return self::FAILURE;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return self::FAILURE;
        }

        if ($user->role !== 'admin') {
            $this->error("User with email '{$email}' is not an admin.");
            return self::FAILURE;
        }

        if ($this->confirm("Are you sure you want to delete the admin user: {$user->name} ({$user->email})?")) {
            try {
                $user->delete();
                $this->info("Admin user '{$user->name}' ({$user->email}) deleted successfully.");
                return self::SUCCESS;
            } catch (\Exception $e) {
                $this->error("An error occurred while deleting the admin user: " . $e->getMessage());
                return self::FAILURE;
            }
        } else {
            $this->info('Admin user deletion cancelled.');
            return self::SUCCESS; // Indicate success for cancellation
        }

    }
}
