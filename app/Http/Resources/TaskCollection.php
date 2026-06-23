<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => TaskResource::collection($this->collection),
            'current_page' => $this->currentPage(),
            'total' => $this->total(),
            'per_page' => $this->perPage(),
            'last_page' => $this->lastPage(),
            'first_page_url' => $this->url(1),
            'last_page_url' => $this->url($this->lastPage()),
            'next_page_url' => $this->nextPageUrl(),
            'prev_page_url' => $this->previousPageUrl(),
            'path' => $this->path(),
            'from' => $this->firstItem(),
            'to' => $this->lastItem(),
        ];
    }
}
