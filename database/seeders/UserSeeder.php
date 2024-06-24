<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'user_id' => Uuid::uuid7()->toString(),
                'email' => 'example1@gmail.com',
                'password' => Hash::make('tester'),
                'is_confirmed' => true,
                'email_confirmed_at' => now(),
                'role' => Role::EMPLOYER->value,
            ],
            [
                'user_id' => Uuid::uuid7()->toString(),
                'email' => 'example2@gmail.com',
                'password' => Hash::make('tester'),
                'is_confirmed' => true,
                'email_confirmed_at' => now(),
                'role' => Role::EMPLOYEE->value,
            ],
        ]);
    }

}
