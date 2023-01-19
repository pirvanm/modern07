<?php

namespace Modules\Partners\Services;

use Illuminate\Http\Request;
use Modules\Partners\Entities\Partner;
use Modules\Partners\Http\Requests\PartnerRequest;

class PartnersService
{
    public function store(array $data)
    {
        $data['status'] = 1;

        Partner::create($data);
    }

    public function getData(Request $request)
    {
        $body = json_decode($request->body, true);

        $partners = Partner::query();

        // need to deal with filters, next thing to do
        $partners = $partners->skip($body['skip'])->take($body['take'])->get()->toArray();

        // think of better approach ( maybe transformers )
        $data = [
            'data' => $partners,
            'total' => Partner::count(),
        ];

        return $data;
    }
}
