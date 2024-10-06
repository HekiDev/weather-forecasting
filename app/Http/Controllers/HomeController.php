<?php

namespace App\Http\Controllers;

use App\Http\Resources\ForecastCollection;
use App\Http\Resources\ForecastResource;
use App\Http\Resources\PlaceResource;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $accept = 'application/json';

        $currentWeather = Http::withHeaders([
                'Accept' => $accept,
            ])->get('api.openweathermap.org/data/2.5/weather', [
                'lat' => '36.2048', // coordinate somewhere in japan just to show current weather
                'lon' => '138.2529',
                'appid' => env('OPEN_WEATHER_API_KEY')
            ]);

        $places = Http::withHeaders([
            'Authorization' => env('FOURSQUARE_API_KEY'),
            'Accept' => $accept,
        ])->get('https://api.foursquare.com/v3/places/search', [
            'query' => request('query'),
            'near' => request('near') ?? 'Tokyo',
        ]);

        $forecast = new ForecastResource($currentWeather->json());
        $places = new PlaceResource($places->json()['results']);

        return Inertia::render('Welcome', [
            'places' => $places,
            'currentWeather' => $forecast,
        ]);
    }

    public function placeForecast($fsq_id)
    {
        $accept = 'application/json';

        $place = Http::withHeaders([
            'Authorization' => env('FOURSQUARE_API_KEY'),
            'Accept' => $accept,
        ])->get('https://api.foursquare.com/v3/places/'.$fsq_id);

        $placeJson = $place->json();

        $forecasts = Http::withHeaders([
                'Accept' => $accept,
            ])->get('api.openweathermap.org/data/2.5/forecast', [
                'lat' => $placeJson['geocodes']['main']['latitude'],
                'lon' => $placeJson['geocodes']['main']['longitude'],
                'appid' => env('OPEN_WEATHER_API_KEY')
            ]);

        return Inertia::render('PlaceForcast', [
            'place' => $placeJson,
            'forecasts' => new ForecastCollection($forecasts->json()['list']),
        ]);
    }
}
