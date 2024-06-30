<?php

namespace Database\Seeders;

use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(100)
            ->has(
                Employer::factory()->state(
                    function (array $attributes, User $user) {
                        return ['contact_email' => $user->email];
                    }
                )
            )->state(['role' => 'employer'])->create();
    }

}
