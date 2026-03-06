<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            // We use optional() just in case a category was deleted
            'category' => optional($this->category)->name,
            'status' => $this->users()->exists() ? 'Borrowed' : 'Available',
        ];
    }
}