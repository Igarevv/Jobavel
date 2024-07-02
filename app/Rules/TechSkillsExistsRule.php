<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class TechSkillsExistsRule implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {
        if ( ! $this->ensureFieldOfArrayIsNum($value) || ! $this->ensureSkillIdsExists($value)) {
            $fail('The :attribute fields is incorrect');
        }
    }

    public function ensureFieldOfArrayIsNum(array $value): bool
    {
        foreach ($value as $item) {
            if ( ! is_numeric($item)) {
                return false;
            }
        }
        return true;
    }

    public function ensureSkillIdsExists(array $value): bool
    {
        $categoriesCount = DB::table('tech_skills')
            ->whereIn('id', $value)
            ->count();

        return count($value) === $categoriesCount;
    }

}
