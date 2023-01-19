<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class CloneRoleRequest extends  FormRequest
{
    public function rules() {
        return [
            'name' => 'required|unique:roles,name',
            'guard_name' => 'nullable|string',
            'display_name' => 'nullable|string',
            'description' =>'nullable|string'
        ];
    }

    /**
     * Determine if the use is authorized to make this request
     * @return bool
     */
    public function authorize () {
        return true;
    }
}
