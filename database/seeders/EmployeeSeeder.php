<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class EmployeeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = DB::table('users')
            ->select('id')
            ->where('email', 'example2@gmail.com')
            ->first();
        DB::table('employees')->insert([
            [
                'employee_id' => Uuid::uuid7()->toString(),
                'user_id' => $user->id,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'example2@gmail.com',
            ],
        ]);
    }

}
