<?php

namespace Database\Seeders;

use App\Persistence\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::query()->truncate();
        //$employer = Employee::factory()->create();
        /* User::factory(1)
             ->has(
                 Employee::factory()->state(
                     function (array $attributes, User $user) {
                         return ['email' => $user->email];
                     }
                 )
             )->state(['role' => 'employee'])->create();*/
    }

}
