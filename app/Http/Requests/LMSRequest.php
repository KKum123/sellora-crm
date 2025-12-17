<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LMSRequest extends FormRequest
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
            'trainingName'     => 'required',
            'trainingMaterial' => 'required',
            'uploadPDF'        => 'nullable',
            'uploadImage'      => 'nullable',
            'uploadVideo'      => 'nullable'
        ];
    }
}
