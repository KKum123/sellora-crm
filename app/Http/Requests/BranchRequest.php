<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        $id = $this->input('id') ?? null;
        
        return [
           'country' => 'required',
            'branch_name' => 'required',
            'branch_code' => 'required',
            'manager_name' => 'required',
            'email' => 'required|email|max:255|unique:branches,email,'. $id,
            'mobile' => 'required|digits:10|',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'password' => 'required',
        ];
    }
}
