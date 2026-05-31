<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeSpaceResource extends JsonResource
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
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'address' => $this->address,
            'is_open' => $this->is_open,
            'is_full_booked' => $this->is_full_booked,
            'price' => $this->price,
            'duration' => $this->duration,
            'about' => $this->about,
            'city' => new CityResource($this->whenLoaded('city')),
            'slug' => $this->slug,
            'photos' => OfficeSpacePhotoResource::collection($this->whenLoaded('officeSpacePhotos')),
            'benefits' => OfficeSpaceBenefitResource::collection($this->whenLoaded('benefits')),
        ];
    }
}
