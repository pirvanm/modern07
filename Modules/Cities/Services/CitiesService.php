<?php

namespace Modules\Cities\Services;

use Modules\Cities\Entities\City;
use Illuminate\Http\Request;

class CitiesService
{
    public function search(Request $request): array
    {
        $cities = [];

        // we can have a filter ( scope ) here
        // probably more filters, in the future
        if ($request->has('q')) {
            $cities = City::query()->searchByName($request->q)->get()->toArray();
        }

        return $cities;
    }

    public function getCities(Request $request): array
    {
        $body = json_decode($request->body, true);

        $cities = City::query();

        // need to deal with filters, next thing to do
        $cities = $cities->skip($body['skip'])->take($body['take'])->get()->toArray();

        // think of better approach ( transformers )
        $data = [
            'data' => $cities,
            'total' => City::count(),
        ];

        return $data;
    }
}
