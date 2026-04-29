<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:1200'],
            'price_tzs' => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:5'],
            'is_active' => ['boolean'],
        ];
    }
}
