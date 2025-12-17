<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
            'requester_name'            => 'required',
            'phone'                     => 'required',
            'email'                     => 'required',
            'city'                      => 'required',
            'service_category'          => 'nullable',
            'requester_location'        => 'nullable',
            'requester_sell_in_country' => 'nullable',
        ];
    }
}
