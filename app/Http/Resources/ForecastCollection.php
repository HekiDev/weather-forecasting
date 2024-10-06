<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForecastCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $original = parent::toArray($request);

        $data = collect($original)->map(function ($item) {
            return [
                'date' => $item['dt'] ?? null,
                'temperature' => $item['main']['temp'] ?? 0,
                'weather_status' => $item['weather'][0]['main'] ?? null,
                'feels_like' => $item['main']['feels_like'] ?? null,
                'wind_speed' => $item['wind']['speed'] ?? 0,
                'visibility' => $item['visibility'] ?? 0,
                'clouds' => $item['clouds']['all'] ?? 0,
            ];
        });
        return $data->toArray();
    }
}
