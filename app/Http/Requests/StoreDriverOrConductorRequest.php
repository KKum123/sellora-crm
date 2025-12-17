<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverOrConductorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Allow the request to proceed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'driver_contactor_full_name' => 'required|string|max:255',
            'mobile' => 'required|regex:/^[0-9]{10}$/|unique:driver_or_conductors,mobile,' . $this->input('id'),
            'email' => 'required|email|unique:driver_or_conductors,email,' . $this->input('id'),
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string',
            'gender' => 'required',
            'address' => 'nullable|string',
          
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'mobile.required' => 'The mobile number is required.',
            'mobile.regex' => 'The mobile number must be exactly 10 digits.',
            'mobile.unique' => 'This mobile number is already in use.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email is already in use.',
           
        ];
    }
}
