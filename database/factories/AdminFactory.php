<?php

namespace Database\Factories\Persistence\Models;

use App\Enums\Admin\AdminAccountStatusEnum;
use App\Persistence\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Persistence\Models\Admin>
 */
class AdminFactory extends Factory
{

    protected $model = Admin::class;

    public function definition(): array
    {
        return [
            'admin_id' => Uuid::uuid7()->toString(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->safeEmail(),
            'password' => Hash::make('admin12345'),
            'is_super_admin' => false,
            'account_status' => AdminAccountStatusEnum::ACTIVE->value,
            'api_token' => Str::random(60)
        ];
    }
}
