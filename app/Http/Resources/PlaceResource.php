<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $original = parent::toArray($request);

        $data = collect($original)->map(function ($item) {
            return [
                'fsq_id' => $item['fsq_id'],
                'categories' => $item['categories'],
                'distance' => $item['distance'],
                'geocodes' => $item['geocodes'],
                'location' => $item['location'],
                'name' => $item['name'],
            ];
        });
        return $data->toArray();
    }
}
