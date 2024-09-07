<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminTable extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->resource->items(),
            'current_page' => $this->resource->currentPage(),
            'last_page' => $this->resource->lastPage(),
            'next_page_url' => $this->resource->nextPageUrl(),
            'prev_page_url' => $this->resource->previousPageUrl(),
            'per_page' => $this->resource->perPage(),
            'total' => $this->resource->total()
        ];
    }
}
