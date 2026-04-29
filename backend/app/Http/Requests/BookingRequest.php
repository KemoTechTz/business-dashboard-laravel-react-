<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $businessId = $this->user()->business_id;

        return [
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where(fn ($query) => $query->where('business_id', $businessId)),
            ],
            'service_id' => [
                'required',
                Rule::exists('services', 'id')->where(fn ($query) => $query->where('business_id', $businessId)),
            ],
            'staff_id' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('business_id', $businessId)),
            ],
            'scheduled_for' => ['required', 'date'],
            'status' => ['required', 'in:pending,completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
