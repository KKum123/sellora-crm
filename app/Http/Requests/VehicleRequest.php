<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'vehicle_name' => 'required',
            'vehicle_type_id' => 'required',
            'registration_number' => 'required',
            'seating_capacity' => 'required',
            'insurance_company' => 'required',
            'policy_number' => 'required',
            'expiry_date' => 'required',

        ];
    }
}
