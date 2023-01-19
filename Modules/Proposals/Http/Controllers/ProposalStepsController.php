<?php

namespace Modules\Proposals\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;

class ProposalStepsController extends Controller
{
    public function validateStep(Request $request, string $step)
    {
        switch ($step) {
            case 'location':

            case 'address':
                return $this->validateAddress($request);
            case 'owner':
                return $this->validateOwner($request);
            case 'space':
                return $this->validateSpace($request);
            case 'rent':
                return $this->validateRent($request);
            case 'competition':
                return $this->validateCompetition($request);
            case 'note':
                return $this->validateNote($request);
        }
    }

    public function validateLocation(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id'
        ]);

        return Redirect::back();
    }

    public function validateAddress(Request $request)
    {
        $request->validate([
            'address.neighborhood' => 'nullable|string',
            'address.street_name' => 'nullable|string',
            'address.street_number' => 'nullable|string',
            'address.building_number' => 'nullable|string',
            'address.building_entrance' => 'nullable|string',
            'address.apartment_floor' => 'nullable|string',
            'address.apartment_number' => 'nullable|string',
            'address.notes' => 'nullable|string',
        ]);

        return Redirect::back();
    }

    public function validateSpace(Request $request)
    {
        $request->validate([
            'space.agency_type' => 'required|string',
            'space.space_type' => 'required|string',
            'space.area_annexes'=> 'required|string',
            'space.street_type' => 'nullable|string',
            'space.total_area' => 'nullable|string',
            'space.street_front' => 'nullable|string',
            'space.floor' => 'nullable|string',
            'space.grade' => 'nullable|numeric',
            'space.bathroom' => 'nullable',
            'space.company_agency' => 'nullable|string',
        ]);

        return Redirect::back();
    }

    public function validateOwner(Request $request)
    {
        $request->validate([
            'owner.name' => 'nullable',
            'owner.company' => 'nullable',
            'owner.email' => 'nullable|email',
            'owner.phone' => 'nullable',
        ]);

        return Redirect::back();
    }

    public function validateRent(Request $request)
    {
        $request->validate([
            'rent.*' => 'nullable',
        ]);

        return Redirect::back();
    }

    public function validateCompetition(Request $request)
    {
        $request->validate([
            'competition.*.*' => 'nullable',
        ]);

        return Redirect::back();
    }

    public function validateNote(Request $request)
    {
        $request->validate([
            'note' => 'nullable',
        ]);

        return Redirect::back();
    }
}
