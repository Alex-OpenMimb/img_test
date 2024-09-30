<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
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
            'name'                  => $this->name,
            'image'                 => $this->image,
            'expiration_date'       => $this->expiration_date,
            'created_at'            => date_format($this->created_at, 'Y-m-d, h:m'),
            'updated_at'            => date_format($this->updated_at, 'Y-m-d, h:m'),
        ];
    }
}
