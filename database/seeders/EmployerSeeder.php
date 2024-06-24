<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class EmployerSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = DB::table('users')
            ->select('id')
            ->where('email', 'example1@gmail.com')
            ->first();
        DB::table('employers')->insert([
            [
                'employer_id' => Uuid::uuid7()->toString(),
                'user_id' => $user->id,
                'company_name' => 'Google Inc.',
                'contact_email' => 'example1@gmail.com',
                'company_description' => 'Google LLC is an American multinational corporation and technology company focusing on online advertising,
                    search engine technology, cloud computing, computer software, quantum computing, e-commerce, consumer electronics,
                    and artificial intelligence (AI).
                    It has been referred to as "the most powerful company in the world" and is one of the world\'s most valuable brands due to its market dominance,
                    data collection, and technological advantages in the field of AI. Google\'s parent company, Alphabet Inc.',
            ],
        ]);
    }

}
