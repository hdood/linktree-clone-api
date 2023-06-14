<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {




        return [
            'id' => $this->id,
            'theme_id' => $this->theme_id,
            'name' => $this->name,
            'designation' => $this->designation,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'bio' => $this->bio,
            'phone' => $this->phone,
            'country_code' => $this->country_code,
            'address' => $this->address,
            'website' => $this->website,
            'phone_visibility' => $this->phone_visibility == 1 ? true : false,
            'image' => strpos($this->image, "http") !== false ?  $this->image : url('/') . $this->image,
            'cover_image' => url('/') . $this->cover_image,
            'portfolio' => !$this->portfolio  ? "" : url('/') . Storage::url($this->portfolio),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
