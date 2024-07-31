<?php

namespace Database\Seeders;

use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{

    public function run(): void
    {
        Employer::query()->truncate();

        $users = User::factory(3)->has(
            Employer::factory()->state(
                function (array $attributes, User $user) {
                    return ['contact_email' => $user->email];
                }
            )
        )->state(['role' => User::EMPLOYER])->create();

        $users->each(function (User $user) {
            $user->assignRole(User::EMPLOYER);
        });
    }
}
