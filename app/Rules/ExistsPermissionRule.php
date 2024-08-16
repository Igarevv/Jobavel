<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Spatie\Permission\Models\Permission;

class ExistsPermissionRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            $fail('Permissions data type in invalid');
        }

        $countPermissions = Permission::query()->whereIn('name', $value)->count();

        if (count($value) !== $countPermissions) {
            $fail('Given permissions is not exists.');
        }
    }
}
