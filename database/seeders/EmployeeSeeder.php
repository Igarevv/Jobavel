<?php

namespace Database\Seeders;

use App\Persistence\Models\Employee;
use App\Persistence\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(
                Employee::factory()->state(
                    function (array $attributes, User $user) {
                        return ['email' => $user->email];
                    }
                )
            )->state(['role' => 'employee'])->create();
    }

}
