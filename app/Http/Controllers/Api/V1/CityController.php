<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CityResource;
use App\Models\City;


class CityController extends Controller
{
    public function index()
    {
        $cities = City::withCount('officeSpaces')->get();
        return CityResource::collection($cities);
    }

    public function show(City $city)
    {
        $city->load('officeSpaces.city', 'officeSpaces.photos');
        $city->loadCount('officeSpaces');
        return new CityResource($city);
    }
}
