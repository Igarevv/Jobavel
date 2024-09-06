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
                'publishedAt' => $vacancy->published_at->format('Y-m-d H:i').' '.$vacancy->published_at->getTimezone(),
                'createdAt' => $vacancy->created_at->format('Y-m-d H:i').' '.$vacancy->created_at->getTimezone()
            ];
        })->toArray();
    }
}
