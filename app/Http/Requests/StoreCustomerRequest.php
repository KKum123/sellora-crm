<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * @return bool
     */
    public function authorize()
    {
        return true; // Set this to true if authorization is not required
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * @return array
     */
    public function rules()
    {
        $customerId = $this->input('id') ?? null; // Assuming route model binding with 'customer'
        
        return [
            'name' => 'required|string|max:255',
            'mobile' => [
                'required',
                'regex:/^[0-9]{10}$/',
                'unique:customers,mobile,' . $customerId, // Allows unique validation for updates
            ],
            'email' => [
                'required',
                'email',
                'unique:customers,email,' . $customerId, // Allows unique validation for updates
            ],
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'required|in:Male,Female,Other',
            'state_id' => 'required',
            'district_id' => 'required',
            'municipality_id' => 'nullable',
            'postal_code_or_word_no' => 'nullable',
            'address' => 'nullable',
        ];
    }

    /**
     * Custom messages for validation.
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'mobile.required' => 'The mobile number is required.',
            'mobile.regex' => 'The mobile number must be exactly 10 digits.',
            'mobile.unique' => 'The mobile number has already been taken.',
            'email.required' => 'The email address is required.',
            'email.unique' => 'The email address has already been taken.',
        ];
    }
}
