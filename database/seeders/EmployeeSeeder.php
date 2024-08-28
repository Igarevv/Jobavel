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
        Employee::query()->truncate();

        $users = User::factory(3)
            ->has(
                Employee::factory()->state(
                    function (array $attributes, User $user) {
                        return ['email' => $user->email];
                    }
                )
            )->create();

        $users->each(function (User $user) {
            $user->assignRole(User::EMPLOYEE);
        });
    }

}
