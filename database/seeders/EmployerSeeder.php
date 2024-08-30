<?php

namespace Database\Seeders;

use App\Enums\EmployerEnum;
use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

class EmployerSeeder extends Seeder
{

    public function run(): void
    {
        Employer::flushEventListeners();
        User::flushEventListeners();
        Employer::query()->truncate();

        $chunkSize = 9000;
        $records = [];

        for ($i = 0; $i < 100000; $i++) {
            $records[] = [
                'company_name' => fake()->company() . $i,
                'company_description' => fake()->paragraph(1),
                'employer_id' => Uuid::uuid7()->toString(),
                'company_type' => Arr::random([
                    EmployerEnum::COMPANY_TYPE_OUTSTAFF->value,
                    EmployerEnum::COMPANY_TYPE_AGENCY->value,
                    EmployerEnum::COMPANY_TYPE_OUTSOURCE->value,
                    EmployerEnum::COMPANY_TYPE_PRODUCT->value
                ]),
                'company_logo' => 'default_logo.png',
                'contact_email' => \Illuminate\Support\Str::random().$i.'@gmail.com',
                'user_id' => 1
            ];

            if (count($records) === $chunkSize) {
                Employer::query()->insert($records);
                unset($records);
            }
        }


        if (count($records) > 0) {
            Employer::query()->insert($records);
            unset($records);
        }

        /*$users = User::factory(3)->has(
            Employer::factory()->state(
                function (array $attributes, User $user) {
                    return ['contact_email' => $user->email];
                }
            )
        )->create();

        $users->each(function (User $user) {
            $user->assignRole(User::EMPLOYER);
        });*/
    }
}
