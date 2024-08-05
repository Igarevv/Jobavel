<?php

namespace App\Console\Commands;

use App\Persistence\Models\User;
use Database\Factories\Persistence\Models\UserFactory;
use Illuminate\Console\Command;

class RetrieveUserForLogin extends Command
{

    protected $signature = 'test:give-user {role?}';

    protected $description = 'Simple way quickly retrieve registered user for login';

    public function handle(): void
    {
        $role = $this->choice(
            question: 'Which type of user do you want to retrieve?',
            choices: ['employer', 'employee'],
            attempts: 3
        );

        try {
            $user = User::query()->select('email')
                ->where('role', $role)->inRandomOrder()->first();
        } catch (\Throwable $throwable) {
            $this->error('Something went wrong when retrieve user from db');
        }

        $this->info('Success. Your test user:');

        $this->table(['Email', 'Password'], [[$user->email, UserFactory::TEST_PASSWORD]]);

        $this->newLine();
    }

}
