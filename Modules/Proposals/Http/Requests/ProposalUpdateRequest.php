<?php

namespace Modules\Proposals\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProposalUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address.neighborhood' => 'nullable|string',
            'address.street_name' => 'nullable|string',
            'address.street_number' => 'nullable|string',
            'address.building_number' => 'nullable|string',
            'address.building_entrance' => 'nullable|string',
            'address.apartment_floor' => 'nullable|string',
            'address.apartment_number' => 'nullable|string',
            'address.notes' => 'nullable|string',
            'space.agency_type' => 'required|string',
            'space.street_type' => 'nullable|string',
            'space.total_area' => 'nullable|string',
            'space.area_annexes' => 'nullable|string',
            'space.street_front' => 'nullable|string',
            'space.floor' => 'nullable|string',
            'space.grade' => 'nullable|numeric',
            'space.bathroom' => 'nullable',
            'space.company_agency' => 'nullable|string',
            'owner.name' => 'nullable',
            'owner.company' => 'nullable',
            'owner.email' => 'nullable|email',
            'owner.phone' => 'nullable',
            'rent.*' => 'nullable',
            'competition.*.*' => 'nullable',
            'note' => 'nullable',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
