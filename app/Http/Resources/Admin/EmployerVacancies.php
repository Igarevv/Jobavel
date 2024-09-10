<?php

namespace App\Http\Resources\Admin;

use App\Persistence\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerVacancies extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->resource->map(function (Vacancy $vacancy) {
            return (object) [
                'id' => $vacancy->id,
                'slug' => $vacancy->slug,
                'title' => $vacancy->title,
                'location' => $vacancy->location,
                'employment' => $vacancy->employment_type,
                'response' => $vacancy->response_number,
                'publishedAt' => $vacancy->publishedAtToString(),
                'createdAt' => $vacancy->createdAtString()
            ];
        })->toArray();
    }
}
