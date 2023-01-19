<?php

namespace Modules\Openings\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Openings\Entities\Opening;
use Modules\Proposals\Entities\Proposal;

class OpeningsService
{
    public function store(array $data)
    {
        //..
    }

    public function getOpenings(Request $request)
    {
        $body = json_decode($request->body, true);

        $openings = Opening::query()->with('proposal');

        // need to deal with filters, next thing to do
        $openings = $openings->skip($body['skip'])->take($body['take'])->get()->toArray();

        // think of better approach
        $data = [
            'data' => $openings,
            'total' => Opening::count(),
        ];

        return $data;
    }
}
