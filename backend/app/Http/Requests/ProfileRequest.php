<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    // this function for postman PUT request to accept multipart data
    public function prepareForValidation()
    {
        if ($this->isJson()) {
            $this->merge($this->json()->all());
        }
    }

    public function rules(): array
    {
        return [
            'bio' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'image' => 'nullable|string',
        ];
    }
}
