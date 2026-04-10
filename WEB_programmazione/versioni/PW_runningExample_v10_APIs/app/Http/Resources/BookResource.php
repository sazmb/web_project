<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'book_title' => $this->title,
            //'authored by' => $this->firstname . " " . $this->lastname,
            'authored by' => new AuthorResource($this->author),
        ];
    }
}
