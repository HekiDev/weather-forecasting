<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForecastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        parent::toArray($request);
        return [
            'date' => $this['dt'] ?? null,
            'temperature' => $this['main']['temp'] ?? 0,
            'weather_status' => $this['weather'][0]['main'] ?? null,
            'feels_like' => $this['main']['feels_like'] ?? null,
            'wind_speed' => $this['wind']['speed'] ?? 0,
            'visibility' => $this['visibility'] ?? 0,
            'clouds' => $this['clouds']['all'] ?? 0,
        ];
    }
}
