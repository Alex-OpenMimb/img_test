<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'description'           => $this->description,
            'image'                 => $this->image,
            'creation_date'         => $this->creation_date,
            'expiration_date'       => $this->expiration_date,
            'user'                  => $this->user->name,
            'tag'                   => $this->tag->name,
            'tag_id'                => $this->tag_id,
            'created_at'            => date_format($this->created_at, 'Y-m-d, h:m'),
            'updated_at'            => date_format($this->updated_at, 'Y-m-d, h:m'),
        ];
    }
}
